<?php

namespace App\Services;



use Illuminate\Support\Facades\Http;

class ContactService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function createContactRequest($body = [])
    {
        // $response = $this->client->withBasicAuth(env('RAZORPAY_API_KEY'), env('RAZORPAY_KEY_SECRET'))->withHeaders([
        //     "Content-Type" => "application/json"
        // ])->post(config('constants.contactsApis.add_contact'), [
        //     'name' => $request->post('name'),
        //     'email' => $request->post('email'),
        //     'contact' => $request->post('phone'),
        //     'type' => $request->post('type'),
        // ]);
    }
}
