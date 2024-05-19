<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderOrderCourierSteadFastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_order_courier_stead_fasts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->bigInteger('cod_amount')->nullable();
            $table->string('consignment_id',50)->nullable();
            $table->string('created_at',50)->nullable();
            $table->string('invoice',50)->nullable();
            $table->text('note')->nullable();
            $table->string('recipient_phone',50)->nullable();
            $table->text('recipient_address')->nullable();
            $table->string('recipient_name',100)->nullable();
            $table->text('status')->nullable();
            $table->string('tracking_code',100)->nullable();
            $table->string('updated_at',50)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_order_courier_stead_fasts');
    }
}
