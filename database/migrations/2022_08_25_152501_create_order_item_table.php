<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('products_id')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->decimal('price',5,2)->nullable();
            $table->decimal('total',5,2)->nullable();
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
        Schema::dropIfExists('order_item');
    }
}
