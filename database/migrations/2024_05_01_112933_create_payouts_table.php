<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->string("payout_id");
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('fund_account_id');
            $table->string("debit_from");
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3);
            $table->decimal('fees', 15, 2);
            $table->decimal('tax', 15,2);
            $table->string('status',50);
            $table->string("utr")->nullable();
            $table->string("mode");
            $table->string("purpose");
            $table->string("reference_id")->nullable();
            $table->string("narration")->nullable();
            $table->json('status_details');
            $table->datetime("created_at")->useCurrent();
            $table->datetime("updated_at")->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payouts');
    }
}
