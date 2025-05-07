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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            // Foreign key reference to the product table
            $table->unsignedBigInteger('product_id');

            // Variant-specific attributes
            $table->string('label')->nullable(); // e.g. "Large", "Blue"
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('si_unit')->nullable();
            $table->string('weight')->nullable();
            $table->double('stock_price', 8, 2);
            $table->double('sale_price', 8, 2);
            $table->integer('available_stock')->default(0); // Track stock for each variant
            $table->integer('sold')->unique()->nullable(); // Unique variant SKU if necessary

            // Add the foreign key constraint to the product_id field
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
