<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index()
    {
        return view('payout.index');
    }

    public function create()
    {
        return view('payout.create');
    }
}
