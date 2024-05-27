<?php

use App\Http\Controllers\Contact;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Fund;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\RazorpayWebhookController;
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

Route::get("generate-email-phone-number", function () {
    $phoneNumber = PhoneNumber::mobileNumber();
    $email = \Faker\Factory::create()->freeEmail;
    dd([$email, $phoneNumber]);
});


Route::get('/', function () {
    return view('welcome');
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
    Route::get("fund-accounts-view/{contactId}", [Fund::class, 'viewAccounts'])->name('fund.accounts.view');
    Route::get("fund-account-mark-status/{fund}", [Fund::class, 'markStatus'])->name('fund.account.mark.status');

    Route::controller(PayoutController::class)->name('payout.')->group(function () {
        Route::get("payouts", 'index')->name('index');
        Route::get("payout/create", 'create')->name('create');
    });
});

// ? Razorpay Webhook Payload Check Route
// Route::get('/getPayload', [RazorpayWebhookController::class, 'getPayload']);

Route::post('/payout-processed', [RazorpayWebhookController::class, 'payoutProcessed']);
