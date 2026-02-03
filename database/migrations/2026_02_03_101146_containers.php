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
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->string('container_id')->unique();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('image_id')->nullable();
            $table->string('state')->nullable();
            $table->string('status')->nullable();
            $table->json('ports')->nullable();
            $table->json('labels')->nullable();
            $table->json('network_settings')->nullable();
            $table->json('mounts')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};
