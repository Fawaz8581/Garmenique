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
        Schema::create('page_setting_images', function (Blueprint $table) {
            $table->id();
            $table->string('page', 50);
            $table->string('section', 50);
            $table->string('image_key', 100);
            $table->text('image_data')->nullable();
            $table->timestamps();
            
            $table->unique(['page', 'section', 'image_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_setting_images');
    }
};
