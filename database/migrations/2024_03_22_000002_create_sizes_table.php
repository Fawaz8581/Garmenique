<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('sizes')) {
            Schema::create('sizes', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->enum('type', ['number', 'clothing']);
                $table->timestamps();
                $table->unique(['name', 'type']);
            });
        }

        // Create pivot table for products and sizes if it doesn't exist
        if (!Schema::hasTable('product_sizes')) {
            Schema::create('product_sizes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('size_id')->constrained()->onDelete('cascade');
                $table->integer('stock')->default(0);
                $table->timestamps();
                $table->unique(['product_id', 'size_id']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('product_sizes');
        Schema::dropIfExists('sizes');
    }
}; 