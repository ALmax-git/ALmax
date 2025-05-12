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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->references('id')->on('clients')->onDelete('cascade');
            $table->foreignId('message_id')->nullable()->references('id')->on('messages')->onDelete('cascade');

            $table->foreignId('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('reciever_id')->nullable()->references('id')->on('users')->onDelete('cascade');

            $table->enum('status', ['unread', 'read', 'draft'])->default('unread'); // unread /read
            $table->string('level')->default('info'); // info, success, warning, danger | client only 
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
