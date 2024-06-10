<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayoutApiService
{

    public static function createPayoutToBankAccount($data)
    {
        $postData = [
            'account_number'  => '2323230087440720',
            'fund_account_id' => $data['fund_account_id'],
            'amount'          => $data['amount'] * 100,
            'currency'        => "INR",
            'mode'            => $data['payment_mode'],
            'purpose'         => $data['purpose'],
            'reference_id'    => $data['reference_id'],
            'narration'       => $data['narration']
        ];

        $response =  Http::withBasicAuth(env('RAZORPAY_API_KEY'), env('RAZORPAY_KEY_SECRET'))->withHeaders([
            "Content-Type" => "application/json"
        ])->post(config('constants.payoutApis.both'), $postData);

        return $response;
    }
}
