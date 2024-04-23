<?php

namespace App\Http\Controllers;

use App\Models\Contact as ModelsContact;
use App\Services\ContactApiService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Contact extends Controller
{
    public function index()
    {
        $contacts =  Cache::remember('contacts', now()->addHour(), function () {
            return ModelsContact::all(['id', 'razorpay_con_id', 'name', 'email', 'phone', 'type', 'status']);
        });

        return view('contact.index', compact('contacts'));
    }

    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:3|max:50',
                'email' => 'required|email|unique:contacts,email',
                'phone' => 'required|numeric|digits:10',
                'type' => 'required|string|in:vendor,customer,employee,self',
            ]);

            if ($validator->fails()) {
                return redirect("admin/contact/create")->withErrors($validator);
            }

            $contactService = ContactApiService::addContact($request->only(['name', 'email', 'phone', 'type']));

            if ($contactService->failed()) {
                return redirect()->to('admin/contact/create')->with('error', $contactService->object()->error->description);
            }

            $contact = new ModelsContact();
            $contact->razorpay_con_id = $contactService->json('id');
            $contact->name = $contactService->json('name');
            $contact->email = $contactService->json('email');
            $contact->phone = $contactService->json('contact');
            $contact->type = $contactService->json('type');
            $contact->status = $contactService->json('active');
            $contact->save();

            return redirect("admin/contacts")->with('success', 'Contact added successfully');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect("admin/contacts")->with('error', "Something went wrong please try after sometime.");
        }
    }

    public function markStatus(ModelsContact $contact)
    {
        $newStatus = !$contact->status;

        $data = [
            'contact_id' => $contact->razorpay_con_id,
            'status' => $newStatus
        ];

        $contactService = ContactApiService::changeStatus($data);

        if ($contactService->failed()) {
            return redirect('admin/contacts')->with('error', $contactService->object()->error->description);
        }

        $contact->status = $newStatus;
        $contact->save();

        return redirect('admin/contacts')->with('success', 'Contact status updated successfully');
    }
}
