<?php

use App\Http\Controllers\Contact;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Fund;
use Illuminate\Support\Facades\Route;
use Faker\Provider\en_IN\PhoneNumber;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("generate-phone-number", function(){
    $phoneNumber = PhoneNumber::mobileNumber();
    $email = \Faker\Factory::create()->freeEmail;
    dd([$email, $phoneNumber]);
});

Route::prefix('admin')->group(function () {
    Route::get("dashboard", [Dashboard::class, 'index']);

    Route::get("contacts", [Contact::class, 'index']);
    Route::get("contact/create", [Contact::class, 'create'])->name('contact.create');
    Route::post("contact-store", [Contact::class, 'store'])->name('contact.store');
    Route::get("contact-status-mark/{contact}", [Contact::class, 'markStatus'])->name('contact.markStatus');

    Route::get('funds', [Fund::class, 'index']);
    Route::get("fund/create", [Fund::class, 'create'])->name('fund.create');
    Route::post("fund-store", [Fund::class, 'store'])->name('fund.store');
});
