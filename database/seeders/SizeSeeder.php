<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeSeeder extends Seeder
{
    public function run()
    {
        // Clothing sizes
        $clothingSizes = ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'];
        foreach ($clothingSizes as $size) {
            Size::create([
                'name' => $size,
                'type' => 'clothing'
            ]);
        }

        // Number sizes
        $numberSizes = ['30', '31', '32', '33', '34', '35'];
        foreach ($numberSizes as $size) {
            Size::create([
                'name' => $size,
                'type' => 'number'
            ]);
        }
    }
} 