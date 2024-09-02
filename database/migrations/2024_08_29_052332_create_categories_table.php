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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Category name
            $table->string('slug')->unique(); // Unique slug for URL
            $table->string('description')->nullable(); // Description, nullable
            $table->string('image')->nullable(); // Category image path, nullable
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade'); // Self-referencing foreign key for parent category
            $table->integer('order')->default(0); // Order of display, default 0
            $table->boolean('is_active')->default(true); // Active status, default true
            $table->timestamps(); // Created at and updated at timestamps
            $table->softDeletes(); // Soft delete column, nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
