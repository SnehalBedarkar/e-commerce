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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Foreign key to orders table
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Foreign key to products table
            $table->integer('quantity')->unsigned(); // Quantity of the product in the order
            $table->decimal('price', 10, 2)->unsigned(); // Price of the product at the time of the order
            $table->decimal('total', 10, 2)->unsigned()->virtualAs('quantity * price'); // Total price for this product (computed column)
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
