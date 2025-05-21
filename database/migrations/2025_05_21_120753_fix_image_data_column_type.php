<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the old column and re-create it as BYTEA
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image_data');
        });

        // Use DB::statement for PostgreSQL specific BYTEA type
        DB::statement('ALTER TABLE products ADD image_data BYTEA');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image_data');
            $table->longText('image_data')->nullable();
        });
    }
};
