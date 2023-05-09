<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trans_code');
            $table->string('user_add');
            $table->double('lat')->nullable();
            $table->double('long')->nullable();
            $table->string('phone');
            $table->decimal('total_payment', 8, 2);
            $table->string('payment_opt');
            $table->string('status')->nullable()->default('Approval');
            $table->foreignId('user_id');
            $table->date('date_to_deliver')->nullable();
            $table->date('date_delivered')->nullable();
            $table->string('proof_of_delivery')->nullable();
            $table->string('proof_of_payment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
