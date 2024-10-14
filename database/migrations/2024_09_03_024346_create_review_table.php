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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('Review_id');
            $table->unsignedBigInteger('Customer_id');
            $table->unsignedBigInteger('Product_id');
       
            $table->string('Title');
            $table->string('Description');
            $table->enum('stars', ['0', '1', '2', '3', '4', '5']);
            $table->timestamps();

            $table->foreign('Customer_id')
            ->references('Customer_id')
            ->on('customers');
            
            $table->foreign('Product_id')
            ->references('Product_id')
            ->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};