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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->nullOnDelete();
            $table->integer('quantity')->default(1);
            // $table->decimal('price', 20, 2);
            // $table->decimal('total', 20, 2);    // price * quantity
            $table->enum('status', ['pending', 'comfirmed', 'abandoned', 'completed'])->default('pending');  // pending, confirmed, abandoned
            $table->timestamp('reservation_end_time')->nullable(); // Reservation deadline
            $table->decimal('paid_amount', 20, 2)->default(0);  // How much paid so far
            $table->decimal('installment_balance', 20, 2); // Remaining balance for installments
            $table->boolean('is_selected')->default(true); // select items to check-out
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
