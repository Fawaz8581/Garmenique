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
        Schema::table('products', function (Blueprint $table) {
            // First, drop the existing column if it exists
            if (Schema::hasColumn('products', 'image_data')) {
                $table->dropColumn('image_data');
            }
            
            // Then recreate it with the proper type for binary data
            $table->binary('image_data')->nullable()->after('images');
        });
        
        // For MySQL, we need to modify the column to use LONGBLOB
        // This is needed because Laravel's binary() method might not create a column large enough
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE products MODIFY image_data LONGBLOB');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't want to lose data, so we'll just leave the column as is
    }
};
