<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('OrderItem_id');
            $table->unsignedBigInteger('Product_id');
            $table->unsignedBigInteger('Order_id');
            $table->integer('Quantity');
            $table->timestamps();

            $table->foreign('Product_id')
            ->references('Product_id')
            ->on('products');

            $table->foreign('Order_id')
            ->references('Order_id')
            ->on('orders');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
