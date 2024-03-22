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
        Schema::create('adv_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adv_id')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();

            $table->foreign('adv_id')->references('id')->on('advs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adv_images');
    }
};
