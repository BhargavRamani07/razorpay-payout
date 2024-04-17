<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FundApiService
{

    public static function addFund($data)
    {
        $postData = [
            'contact_id' => $data['contactId'],
            'account_type' => $data['type'],
        ];
        if ($data['type'] == "bank_account") {
            $postData['bank_account'] = [
                'name' => $data['beneficiary_name'],
                'ifsc' => $data['ifsc'],
                'account_number' => $data['account_number']
            ];
        } else if ($data['type'] == "vpa") {
            $postData['vpa'] = [
                'address' => $data['upi_id'],
            ];
        }

        $response =  Http::withBasicAuth(env('RAZORPAY_API_KEY'), env('RAZORPAY_KEY_SECRET'))->withHeaders([
            "Content-Type" => "application/json"
        ])->post(config('constants.fundAccountApis.fund_account'), [
            $postData
        ]);

        return $response;
    }
}
