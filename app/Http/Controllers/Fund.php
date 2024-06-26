<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Fund as ModelsFund;
use App\Rules\UpiIdRule;
use App\Services\FundApiService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class Fund extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ModelsFund::selectRaw("count(*) as count, contact_id")->with(['contact:id,name'])->groupBy('contact_id');
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->editColumn('contact_id', function ($row) {
                    return $row->contact->name;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . route("fund.accounts.view", Crypt::encryptString($row->contact_id)) . '" class="btn bg-gradient-primary btn-sm"><i class="fas fa-money-check"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('fund.index');
    }

    public function create()
    {
        $contacts = Contact::where('status', 1)->get(['razorpay_con_id', 'name']);
        return view('fund.create', compact('contacts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contactId' => 'required|string|exists:contacts,razorpay_con_id',
            'type' => 'required|string|in:vpa,bank_account',
            /** 
             * ? required_if:type,bank_account
             */
            'beneficiary_name' => 'nullable|required_if:type,bank_account|min:3|max:120',
            'account_number' => 'nullable|required_if:type,bank_account|min:5|max:35|confirmed',
            'ifsc' => 'nullable|required_if:type,bank_account|size:11',

            /** 
             * ? required_if:type,vpa
             */
            'upi_id' => ['nullable', 'required_if:type,vpa', 'min:3', 'max:100', new UpiIdRule],
        ]);

        $validator->validate();

        $fundService = FundApiService::addFund($request->only(['contactId', 'type', 'upi_id', 'account_number', 'ifsc', 'beneficiary_name']));

        if ($fundService->failed()) {
            return redirect()->to('admin/fund/create')->with('error', $fundService->object()->error->description);
        }

        $data = [
            'contact_id' => Contact::firstWhere('razorpay_con_id', $request->post('contactId'))->id,
            'razorpay_acc_id' => $fundService->json('id'),
            'account_type' => $fundService->json('account_type'),
            'status' => $fundService->json('active'),
        ];

        if ($request->post('type') == "bank_account") {
            $data['ifsc'] = $fundService->json('ifsc');
            $data['bank_name'] = $fundService->json('bank_name');
            $data['beneficiary_name'] = $fundService->json('name');
            $data['account_number'] = $fundService->json('account_number');
        } else if ($request->post('type') == "vpa") {
            $data['upi_username'] = $fundService->json('vpa')['username'];
            $data['upi_handle'] = $fundService->json('vpa')['handle'];
            $data['upi_address'] = $fundService->json('vpa')['address'];
        }

        $fundAccountRes = ModelsFund::create($data);

        if ($fundAccountRes) {
            return redirect('admin/funds')->with("success", "Fund account created successfully");
        }

        return redirect('admin/fund/create')->with("error", "Fund account creation failed");
    }

    public function viewAccounts($encryptedContactId)
    {
        try {
            $contactId = Crypt::decryptString($encryptedContactId);
            $accounts = ModelsFund::where('contact_id', $contactId)->with(["contact:id,name"])->get();
            return view('fund.account-view', compact('accounts'));
        } catch (Exception $e) {
            return redirect('admin/funds')->with("error", "Something went wrong, please try again.");
        }
    }

    public function markStatus(ModelsFund $fund)
    {

        $newStatus = !$fund->status;

        $data = [
            'fund_account_id' => $fund->razorpay_acc_id,
            'status' => $newStatus
        ];

        $fundService = FundApiService::changeStatus($data);

        if ($fundService->failed()) {
            return redirect('admin/funds')->with('error', $fundService->object()->error->description);
        }

        $fund->status = $fundService->json('active');
        $fund->save();

        return back()->with('success', 'Fund account status updated successfully');
    }
}
