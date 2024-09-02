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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Foreign key to products table
            $table->integer('quantity')->unsigned(); // Quantity of the product in the cart
            $table->decimal('price', 10, 2)->unsigned(); // Price of the product at the time it was added to the cart
            $table->decimal('total', 10, 2)->unsigned()->virtualAs('quantity * price'); // Total price for this item (computed column)
            $table->timestamps(); // Created at and updated at timestamps
            $table->softDeletes(); // Soft delete column, nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
