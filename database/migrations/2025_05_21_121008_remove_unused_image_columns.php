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
            // Drop unused image data column
            $table->dropColumn('image_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Use the previous migration to re-add it if needed
    }
};
