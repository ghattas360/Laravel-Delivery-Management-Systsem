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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('username', 255);
            $table->string('password', 255);
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->integer('age')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 255)->unique();
            $table->string('plate_number', 255)->unique();
            $table->string('pricing_model', 255);
            $table->string("driving_license");
            $table->string("path1")->nullable()->unique();
            $table->string("national_id");
            $table->string("path2")->nullable()->unique();
            $table->boolean('is_active')->default(false);
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
