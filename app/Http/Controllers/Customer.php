<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


class Customer extends Controller
{
    public function index()
    {
        return view('customer.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
            'type' => 'required|string|in:vendor,customer,employee,self',
            'status' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect("admin/customers")->withErrors($validator)->withInput();
        }


        $response = Http::withBasicAuth(env('RAZORPAY_API_KEY'), env('RAZORPAY_KEY_SECRET'))->withHeaders([
            "Content-Type" => "application/json"
        ])->post('https://api.razorpay.com/v1/contacts', [
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'contact' => $request->post('contact'),
            'type' => $request->post('type'),
        ]);

        if ($response->status() != 201) {
        }



        // $customer = new \App\Models\Customer();

        // $customer->name = $request->name;
        // $customer->email = $request->email;
        // $customer->phone = $request->phone;
        // $customer->type = $request->type;
        // $customer->status = $request->status;
        // $customer->note = $request->note;

        // $customer->save();


        return redirect("admin/customers")->with('success', 'Customer added successfully');
    }
}
