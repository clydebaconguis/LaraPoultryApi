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
        // Schema::create('transactions', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('trans_code');
        //     $table->string('user_add');
        //     $table->decimal('total_payment', 8, 2);
        //     $table->string('payment_opt');
        //     $table->string('status')->nullable()->default('Approval');
        //     $table->foreignId('user_id')->constrained()->onDelete('cascade');
        //     $table->timestamps();
        // });
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
