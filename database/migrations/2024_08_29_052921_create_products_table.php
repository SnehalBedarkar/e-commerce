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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name', 100); // Product name
            $table->string('sku')->unique()->nullable(); // Unique Stock Keeping Unit, nullable
            $table->text('description')->nullable(); // Product description, nullable
            $table->decimal('price', 10, 2)->unsigned(); // Product price
            $table->decimal('sale_price', 10, 2)->unsigned()->nullable(); // Sale price, nullable
            $table->integer('stock_quantity')->unsigned(); // Stock quantity
            $table->decimal('weight', 8, 2)->unsigned()->nullable(); // Product weight, nullable
            $table->decimal('length', 8, 2)->unsigned()->nullable(); // Product length, nullable
            $table->decimal('width', 8, 2)->unsigned()->nullable(); // Product width, nullable
            $table->decimal('height', 8, 2)->unsigned()->nullable(); // Product height, nullable
            $table->string('status')->default('active'); // Product status, default 'active'
            $table->boolean('featured')->default(false); // Featured flag, default false
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Foreign key to categories
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null'); // Foreign key to brands, nullable
            $table->string('image')->nullable(); // Main product image path, nullable
            $table->json('additional_images')->nullable(); // Additional images, stored as JSON, nullable
            $table->integer('view_count')->default(0); // Product view count, default 0
            $table->decimal('rating', 3, 2)->unsigned()->nullable(); // Average customer rating, nullable
            $table->integer('review_count')->unsigned()->default(0); // Number of reviews, default 0
            $table->string('meta_title')->nullable(); // SEO meta title, nullable
            $table->text('meta_description')->nullable(); // SEO meta description, nullable
            $table->timestamps(); // Created at and updated at timestamps
            $table->softDeletes(); // Soft delete column, nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
