<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $table = 'payouts';

    protected $fillable = [
        'payout_id',
        'contact_id',
        'fund_account_id',
        'debit_from',
        'amount',
        'currency',
        'fees',
        'tax',
        'status',
        'utr',
        'mode',
        'purpose',
        'reference_id',
        'narration',
        'status_details'
    ];

    public function getAmountAttribute($value)
    {
        return number_format($value / 100, 2, '.');
    }

    public function displayStatus()
    {
        switch ($this->status) {
            case 'pending':
                $this->status = "<span class='badge badge-info'>Pending</span>";
                break;

            case 'queued':
                $this->status = "<span class='badge badge-warning'>Queued</span>";
                break;

            case 'scheduled':
                $this->status = "<span class='badge badge-primary'>Scheduled</span>";
                break;

            case 'processing':
                $this->status = "<span class='badge badge-secondary'>Processing</span>";
                break;

            case 'processed':
                $this->status = "<span class='badge badge-success'>Processed</span>";
                break;

            case 'reversed':
                $this->status = "<span class='badge badge-danger'>Reversed</span>";
                break;

            case 'cancelled':
                $this->status = "<span class='badge badge-danger'>Cancelled</span>";
                break;

            case 'rejected':
                $this->status = "<span class='badge badge-danger'>Rejected</span>";
                break;

            case 'failed':
                $this->status = "<span class='badge badge-danger'>Failed</span>";
                break;

            default:
                $this->status = "<span class='badge badge-secondary'>Unknown</span>";
                break;
        }

        return $this->status;
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
