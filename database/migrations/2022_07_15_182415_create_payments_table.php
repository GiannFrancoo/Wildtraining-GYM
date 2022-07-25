<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float('price');
            $table->datetime('date');
            $table->date('payment_status_updated_at');
            $table->timestamps();
            $table->softDeletes();
            
            $table->unsignedBigInteger('user_subscription_id');
            $table->foreign('user_subscription_id')->references('id')->on('user_subscriptions')->onDelete('cascade');

            $table->unsignedBigInteger('payment_status_id');
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
