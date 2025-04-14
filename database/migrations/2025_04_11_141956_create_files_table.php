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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable();
            $table->string('path')->unique();
            $table->text('description')->nullable();
            // $table->enum('status', ['active', ''])->default('active');
            $table->enum('visibility', ['protected', 'public', 'private'])->default('protected');
            $table->string('info')->nullable();
            $table->string('mimes')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
