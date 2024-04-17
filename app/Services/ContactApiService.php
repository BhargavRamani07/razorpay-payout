<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ContactApiService
{

    public static function addContact($data)
    {

        $response =  Http::withBasicAuth(env('RAZORPAY_API_KEY'), env('RAZORPAY_KEY_SECRET'))->withHeaders([
            "Content-Type" => "application/json"
        ])->post(config('constants.contactsApis.add_contact'), [
            'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['phone'],
            'type' => $data['type'],
        ]);

        return $response;
    }

    public static function changeStatus($data)
    {
        $response =  Http::withBasicAuth(env('RAZORPAY_API_KEY'), env('RAZORPAY_KEY_SECRET'))->withHeaders([
            "Content-Type" => "application/json"
        ])->patch(config('constants.contactsApis.change_status').'/'.$data['contact_id'], [
            'active' => $data['status'],
        ]);

        return $response;
    }
}

?>