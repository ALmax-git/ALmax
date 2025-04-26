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
        Schema::create('addons', function (Blueprint $table) {
            $table->id();

            // The label for the addon (e.g. Extra Chicken, Extra Large)
            $table->string('label')->nullable();

            // The main product (e.g. jollof rice, shoe, laptop)
            $table->foreignId('base_product_id')->constrained('products')->onDelete('cascade');

            // The addon product (e.g. meat, socks, charger)
            $table->foreignId('addon_product_id')->constrained('products')->onDelete('cascade');

            // Is it required?
            $table->boolean('required')->default(false);

            // Category of the addon (e.g. Drink, Accessory, Food Extra)
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addons');
    }
};
