<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;

    protected $table = 'fund_accounts';

    protected $fillable = [
        'contact_id',
        'razorpay_acc_id',
        'account_type',
        'ifsc',
        'bank_name',
        'beneficiary_name',
        'account_number',
        'upi_username',
        'upi_handle',
        'upi_address',
        'status'
    ];
}
