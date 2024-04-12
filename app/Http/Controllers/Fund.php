<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Rules\UpiIdRule;
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
        $customerContacts = Customer::where('status', 1)->get(['razorpay_con_id', 'name']);
        return view('fund.create', compact('customerContacts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contactId' => 'required|string',
            'type' => 'required|string|in:vpa,back_account',
            /** 
             * ? required_if:type,back_account
             */
            'beneficiary_name' => 'nullable|required_if:type,back_account|min:3|max:120',
            'account_number' => 'nullable|required_if:type,back_account|min:5|max:35',
            're_account_number' => 'nullable|required_if:type,back_account|same:account_number',
            'ifsc' => 'nullable|required_if:type,back_account|size:11',

            /** 
             * ? required_if:type,vpa
             */
            'upi_id' => ['nullable', 'required_if:type,vpa', 'min:3', 'max:100', new UpiIdRule],
        ]);

        if ($validator->fails()) {
            return redirect("admin/fund/create")->withErrors($validator);
        }
    }
}
