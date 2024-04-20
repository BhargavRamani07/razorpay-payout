<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'razorpay_con_id',
        'name',
        'email',
        'phone',
        'type',
        'notes',
        'status'
    ];
}
