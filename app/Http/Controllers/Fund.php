<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Rules\UpiIdRule;
use App\Services\FundApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Fund extends Controller
{
    public function index()
    {
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
            'account_number' => 'nullable|required_if:type,bank_account|min:5|max:35',
            're_account_number' => 'nullable|required_if:type,bank_account|same:account_number',
            'ifsc' => 'nullable|required_if:type,bank_account|size:11',

            /** 
             * ? required_if:type,vpa
             */
            'upi_id' => ['nullable', 'required_if:type,vpa', 'min:3', 'max:100', new UpiIdRule],
        ]);

        if ($validator->fails()) {
            return redirect("admin/fund/create")->withErrors($validator);
        }

        $data = Contact::firstWhere('razorpay_con_id', $request->post('contactId'))->id;

        dd($data);

        $fundService = FundApiService::addFund($request->only(['contactId', 'type', 'upi_id', 'account_number', 'ifsc', 'beneficiary_name']));

        if ($fundService->failed()) {
            return redirect()->to('admin/fund/create')->with('error', $fundService->object()->error->description);
        }

        $data = [
            'contact_id' => Contact::firstWhere('razorpay_con_id', $request->post('contactId'))->id,
            'razorpay_acc_id' => $fundService->json('razorpay_acc_id'),
            'account_type' => $fundService->json('account_type'),
            'status' => $fundService->json('active'),
        ];

        if($request->post('type') == "bank_account") {
            $data = [
                'ifsc' => $fundService->json('ifsc'),
                'bank_name' => $fundService->json('bank_name'),
                'beneficiary_name' => $fundService->json('name'),
                'account_number' => $fundService->json('account_number')
            ];
        } else if($request->post('type') == "vpa") {
            $data = [
                'upi_username' => $fundService->json('name'),
                'upi_handle' => $fundService->json('handle'),
                'upi_address' => $fundService->json('address'),
            ];
        }
    }
}
