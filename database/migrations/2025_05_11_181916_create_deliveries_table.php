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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('target_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->foreignId('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreignId('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->double('price')->default(0);
            $table->enum('status', ['delivered', 'ondispute', 'ontransite', 'onreturn', 'returned', 'others'])->default('ontransite');
            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
