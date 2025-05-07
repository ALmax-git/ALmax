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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('organizer_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->enum('type', ['online', 'offline'])->default('online');
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'closed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
