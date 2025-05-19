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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('picture', 255)->nullable();
            $table->decimal('height', 10, 2);
            $table->decimal('width', 10, 2);
            $table->decimal('depth', 10, 2);
            $table->decimal('weight', 10, 2);
            $table->string('weight_unit', 50);
            $table->string('measurement_unit', 50);
            $table->boolean('is_breakable')->default(false);
            $table->boolean('is_flammable')->default(false);
            $table->boolean('has_fluid')->default(false);
            $table->foreignId('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
