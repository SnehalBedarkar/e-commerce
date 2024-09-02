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
        Schema::create('brands', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // Brand name
            $table->string('slug')->unique(); // Unique slug for URL
            $table->text('description')->nullable(); // Description, nullable
            $table->string('logo')->nullable(); // Brand logo image path, nullable
            $table->string('website')->nullable(); // Website URL, nullable
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
        Schema::dropIfExists('brands');
    }
};
