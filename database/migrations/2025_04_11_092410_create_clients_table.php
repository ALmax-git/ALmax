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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->string('tagline')->nullable();
            $table->string('telephone')->nullable();


            $table->string('country_id')->nullable();
            $table->string('state_id')->nullable();
            $table->string('city_id')->nullable();


            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('overview')->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_registered')->default(false);
            $table->boolean('is_verified')->default(false);

            $table->enum('status', ['active', 'suspended', 'setup', 'closed', 'under_review', 'terminated'])->default('setup');

            $table->foreignId('user_id');
            $table->foreignId('category_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
