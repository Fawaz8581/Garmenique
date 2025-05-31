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
        // Create the table first
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('snap_token')->nullable();
            $table->timestamps();
        });

        // Try to add the foreign key, but don't fail if it doesn't work
        try {
            Schema::table('categories', function (Blueprint $table) {
                $table->foreign('parent_id')
                      ->references('id')
                      ->on('categories')
                      ->onDelete('set null');
            });
        } catch (\Exception $e) {
            \Log::error('Could not add foreign key to categories table: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
}; 