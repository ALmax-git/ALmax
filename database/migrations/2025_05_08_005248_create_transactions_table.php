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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->double('amount');
            $table->enum('type', ['credit', 'debit'])->default('credit');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('tx_ref')->unique();
            $table->string('currency', 10)->default('NGN'); // NGN, USD, USDT, etc.
            $table->string('description')->nullable();
            $table->foreignId('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
