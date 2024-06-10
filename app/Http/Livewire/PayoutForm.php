<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use App\Models\Fund;
use App\Models\Payout;
use App\Services\PayoutApiService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PayoutForm extends Component
{
    public $contacts = [];
    public $fundAccounts = [];
    public $paymentModes = [];
    public $accountType = null;
    public $showAmount = false;

    public $contactId = null;
    public $fund_account = null;
    public $amount = null;
    public $purpose = null;
    public $payment_mode = null;
    public $reference = null;
    public $narration = null;


    protected $listeners = [
        'showAmountDetails'
    ];

    protected $rules = [
        'contactId' => 'required|numeric|not_in:0|exists:contacts,id',
        'fund_account' => 'required_with:contactId|numeric|not_in:0|exists:fund_accounts,id',
        'amount'  => 'required|numeric|min:1',
        'purpose'  => 'required',
        'payment_mode'  => 'required',
        'reference'  => 'max:40',
        'narration' => 'max:30|regex:/^[a-zA-Z0-9 ]+$/'
    ];

    protected $messages = [
        'contactId.required' => 'The contact field is required.',
        'contactId.numeric' => 'The contact is invalid.',
        'contactId.not_in' => 'The selected contact is invalid.',
        'contactId.exists' => 'The selected contact is invalid.',

        'fund_account.required_with' => 'The fund account field is required when contact is present.',

        'amount.min' => 'Minimum allowed amount is ₹ 1',
    ];

    public function mount()
    {
        $this->contacts = Contact::whereStatus(1)->get(['id', 'name', 'email', 'phone', 'type'])->toArray();
    }

    public function resetAll()
    {
        $this->reset(['contactId', 'fund_account', 'amount', 'purpose', 'account_number', 'payment_mode', 'reference', 'narration']);
    }

    public function getFundAccounts()
    {
        if ($this->contactId > 0) {
            $this->fundAccounts = Fund::whereStatus(1)->whereContactId($this->contactId)->get(['id', 'account_type', 'bank_name', 'account_number', 'upi_address'])->toArray();
        } else {
            $this->resetAll();
            $this->fundAccounts = null;
        }
    }

    public function showAmountDetails()
    {
        if ($this->fund_account > 0) {
            $this->showAmount = true;
            $this->getPaymentModes($this->fund_account);
        }
    }

    public function getPaymentModes($fundAccountId)
    {
        $fundAccount = Fund::where('id', $fundAccountId)
            ->where('status', 1)
            ->first(['account_type']);

        if ($fundAccount) {
            $this->paymentModes = match ($fundAccount->account_type) {
                'bank_account' => ['NEFT', 'RTGS', 'IMPS', 'card'],
                'vpa' => ['UPI'],
                default => [],
            };
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnlySelf($propertyName);
        if ($propertyName === 'fund_account') {
            $this->accountType = Fund::where('id', $this->fund_account)->value('account_type');
        }
    }

    public function validateOnlySelf($propertyName)
    {
        $this->validateOnly($propertyName);
        if ($propertyName === 'amount') {
            $this->validateAmount();
        }
    }

    public function validateAmount()
    {
        $message = [
            'amount.lte' => $this->accountType === 'vpa' ? 'Amount cannot be bigger than 1 lac for upi' : 'Total Amount cannot be bigger than 10 crores'
        ];
        Validator::make(
            ['amount' => $this->amount],
            [
                'amount' => [
                    'required',
                    'numeric',
                    'min:1',
                    Rule::when($this->accountType === "vpa", 'lte:100000'),
                    Rule::when($this->accountType === "bank_account", 'lte:100000000'),
                ],
            ],
            $message
        )->validate();
    }

    public function storePayout()
    {
        $this->validate();

        try {

            $fundId = Fund::select('id','razorpay_acc_id')->where('id', $this->fund_account)->whereStatus(1)->first();
            $connId = Contact::select('id')->where('id', $this->contactId)->whereStatus(1)->value('id');

            $payoutResponse = PayoutApiService::createPayoutToBankAccount([
                'fund_account_id' => $fundId->razorpay_acc_id,
                'amount' => $this->amount,
                'payment_mode' => $this->payment_mode,
                'purpose' => $this->purpose,
                'reference_id' => $this->reference,
                'narration' => $this->narration
            ]);

            if($payoutResponse->failed()){
                return session()->flash('error', $payoutResponse->object()->error->description);
            }

            $payoutDataRes = Payout::insert([
                'payout_id' => $payoutResponse->json('id'),
                'contact_id' => $connId,
                'fund_account_id' => $fundId->id,
                'debit_from' => config('constants.banking.customer_identifier'),
                'amount' => $payoutResponse->json('amount'),
                'currency' => $payoutResponse->json('currency'),
                'fees' => $payoutResponse->json('fees'),
                'tax' => $payoutResponse->json('tax'),
                'status' => $payoutResponse->json('status'),
                'utr' => $payoutResponse->json('utr'),
                'mode' => $payoutResponse->json('mode'),
                'purpose' => $payoutResponse->json('purpose'),
                'reference_id' => $payoutResponse->json('reference_id'),
                'narration' => $payoutResponse->json('narration'),
                'status_details' => collect($payoutResponse->json('status_details'))->toJson(),
            ]);

            if($payoutDataRes){
                return redirect('admin/payouts')->with('success', 'Payout Created Successfully');
            }else{
                return session()->flash('error', 'Payout Creation Failed. please try again');
            }
            
        } catch (Exception $e) {
            Log::error($e->getMessage());
            session()->flash('error', "Something went wrong. please try again");
        }
    }

    public function render()
    {
        return view('livewire.payout-form');
    }
}
