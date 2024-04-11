<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

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
}
