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
        Schema::create('social__media__accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clients_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreignId('social_media_providers_id')->references('id')->on('social__media__providers')->onDelete('cascade');
            $table->string('account_name', 255)->nullable();
            $table->string('profile_url', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social__media__accounts');
    }
};
