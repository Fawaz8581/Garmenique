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
        Schema::table('products', function (Blueprint $table) {
            // First drop the existing column
            $table->dropColumn('category_id');
            
            // Then add it back with the correct type
            $table->unsignedBigInteger('category_id')->nullable();
            
            // Add foreign key constraint
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['category_id']);
            
            // Drop the column
            $table->dropColumn('category_id');
            
            // Add back the original string column
            $table->string('category_id')->nullable();
        });
    }
};
