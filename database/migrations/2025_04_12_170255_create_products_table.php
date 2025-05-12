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
            $table->id();
            // Define the foreign key to the clients table
            $table->unsignedBigInteger('client_id');

            // Define a relationship to the user (if applicable)
            $table->unsignedBigInteger('user_id');

            // Basic product details
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('category_id');
            $table->text('description')->nullable();
            $table->integer('discount')->nullable();
            $table->double('stock_price', 8, 2)->nullable();
            $table->double('sale_price', 8, 2);
            $table->integer('available_stock')->default(0);
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('si_unit')->nullable();
            $table->string('weight')->nullable();

            // Status as ENUM to restrict the values to specific states
            $table->enum('status', ['verified', 'new', 'inactive', 'out_of_stock', 'discontinued', 'archived'])->default('new');
            // Track how many items have been sold
            $table->integer('sold')->default(0);

            // Add the foreign key constraint to the client_id field
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->timestamps();
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
