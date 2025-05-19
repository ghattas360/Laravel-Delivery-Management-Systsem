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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('status', 255);
            $table->foreignId('takeOf_Address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreignId('dropOf_Address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->decimal('cost', 10, 2);
            $table->string('currency', 255);
            $table->timestamp('scheduled_at')->nullable();
            $table->foreignId('drivers_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->foreignId('packages_id')->references('id')->on('packages')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleveries');
    }
};
