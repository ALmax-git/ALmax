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
        Schema::create('software', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // $table->string('')
            $table->text('description')->nullable();
            $table->double('sale_price', 10, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'archived'])->default('pending');
            $table->string('file_path'); // Encrypted file storage
            $table->string('key')->unique();

            $table->foreignId('developer_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software');
    }
};
