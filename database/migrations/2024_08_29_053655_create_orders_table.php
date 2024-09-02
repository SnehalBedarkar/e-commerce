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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->string('order_number')->unique(); // Unique order number
            $table->decimal('total', 10, 2)->unsigned(); // Total amount for the order
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending'); // Order status
            $table->text('shipping_address')->nullable(); // Shipping address, nullable
            $table->string('shipping_city')->nullable(); // Shipping city, nullable
            $table->string('shipping_state')->nullable(); // Shipping state/province, nullable
            $table->string('shipping_postal_code')->nullable(); // Shipping postal code, nullable
            $table->string('shipping_country')->nullable(); // Shipping country, nullable
            $table->timestamp('shipped_at')->nullable(); // Timestamp when the order was shipped, nullable
            $table->timestamps(); // Created at and updated at timestamps
            $table->softDeletes(); // Soft delete column, nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
