<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->string("razorpay_acc_id");
            $table->string("account_type");
            // ? If account type is bank account then below fields are filed else nothing will be filled
            $table->string("ifsc", 11)->nullable();
            $table->string("bank_name")->nullable();
            $table->string("beneficiary_name", 120)->nullable();
            $table->string('account_number', 35)->nullable();
            // ? If account type is vpa then below fields are filed else nothing will be filled
            $table->string("upi_username")->nullable();
            $table->string("upi_handle")->nullable();
            $table->string('upi_address')->nullable();

            $table->boolean("status")->default(1)->comment("true : active, false : inactive");
            
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->dateTime("created_at")->useCurrent();
            $table->dateTime("updated_at")->useCurrentOnUpdate()->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fund_accounts');
    }
}
