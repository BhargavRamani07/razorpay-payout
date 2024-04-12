<?php

namespace App\Http\Controllers;

use App\Models\Customer as ModelsCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


class Customer extends Controller
{
    public function index()
    {
        $customers = ModelsCustomer::all(['id', 'razorpay_con_id', 'name', 'email', 'phone',    'type', 'status']);
        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|numeric|digits:10',
            'type' => 'required|string|in:vendor,customer,employee,self',
        ]);

        if ($validator->fails()) {
            return redirect("admin/customer/create")->withErrors($validator);
        }


        $response = Http::withBasicAuth(env('RAZORPAY_API_KEY'), env('RAZORPAY_KEY_SECRET'))->withHeaders([
            "Content-Type" => "application/json"
        ])->post(config('constants.contactsApis.add_contact'), [
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'contact' => $request->post('phone'),
            'type' => $request->post('type'),
        ]);


        if ($response->status() != 201) {
            return redirect()->to('admin/customer/create')->with('error', $response->json('description'));
        }

        $customer = new ModelsCustomer();
        $customer->razorpay_con_id = $response->json('id');
        $customer->name = $response->json('name');
        $customer->email = $response->json('email');
        $customer->phone = $response->json('contact');
        $customer->type = $response->json('type');
        $customer->status = $response->json('active');
        $customer->save();

        return redirect("admin/customers")->with('success', 'Customer added successfully');
    }
}
