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
        // For PostgreSQL, we need to use text for large base64 data
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE products ALTER COLUMN image_data TYPE TEXT');
        }
        
        // For MySQL, we can use LONGTEXT
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE products MODIFY image_data LONGTEXT');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't need to revert this change
    }
};
