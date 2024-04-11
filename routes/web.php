<?php

use App\Http\Controllers\Customer;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Fund;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('admin')->group(function () {
    Route::get("dashboard", [Dashboard::class, 'index']);

    Route::get("customers", [Customer::class, 'index']);
    Route::get("customer/create", [Customer::class, 'create'])->name('customer.create');
    Route::post("customer-store", [Customer::class, 'store'])->name('customer.store');

    Route::get('funds', [Fund::class, 'index']);
    Route::get("fund/create", [Fund::class, 'create'])->name('fund.create');
});
