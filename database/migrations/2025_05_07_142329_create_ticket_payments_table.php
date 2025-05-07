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
        Schema::create('ticket_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('event_id')->references('id')->on('events')->onDelete('cascade');

            $table->string('reference')->unique(); // External ref (e.g. Flutterwave ref)
            $table->string('internal_ref')->unique(); // Internal tracking ref (e.g. TXN-XXXXX)

            $table->double('amount', 20, 2);
            $table->string('currency', 10)->default('NGN'); // NGN, USD, USDT, etc.

            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->json('meta')->nullable(); // store extra data (payment logs, user IP, etc.)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_payments');
    }
};
