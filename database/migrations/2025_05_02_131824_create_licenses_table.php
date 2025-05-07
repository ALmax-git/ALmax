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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->longText('certificate');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreignId('software_id')->references('id')->on('software')->onDelete('cascade');

            $table->text('key')->unique();                  // The license key

            $table->enum('type', ['trial', 'subscription', 'lifetime'])->default('trial'); // License type
            $table->enum('status', ['active', 'expired', 'revoked'])->default('active');

            $table->timestamp('activated_at')->nullable();      // First activation timestamp
            $table->timestamp('expires_at')->nullable();          // Expiration date (null for lifetime)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
