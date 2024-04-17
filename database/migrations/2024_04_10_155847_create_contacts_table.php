<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string("razorpay_con_id");
            $table->string("name");
            $table->string("email");
            $table->string("phone");
            $table->enum("type", ["vendor", "customer", "employee", "self"]);
            $table->boolean("status")->default(1)->comment("true : active, false : inactive");
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
        Schema::dropIfExists('contacts_table');
    }
}
