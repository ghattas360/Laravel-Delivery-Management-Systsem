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
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->integer('age')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 255)->unique();
            $table->string('premium_level', 255)->nullable();
            $table->string('user_name', 255)->unique();
            $table->string('password', 255)->nullable();
            $table->string('profile_image', 255)->unique()->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            // Add custom timestamp columns
            $table->timestamp('created_on')->nullable();
            $table->timestamp('updated_on')->nullable();
            
            $table->timestamps(); // This will add 'created_at' and 'updated_at'
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
