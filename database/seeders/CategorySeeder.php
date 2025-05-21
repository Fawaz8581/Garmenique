<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'T-Shirts',
                'description' => 'Men\'s and women\'s T-shirts'
            ],
            [
                'name' => 'Jeans',
                'description' => 'Men\'s and women\'s jeans'
            ],
            [
                'name' => 'Dresses',
                'description' => 'Women\'s dresses'
            ],
            [
                'name' => 'Outerwear',
                'description' => 'Jackets, coats, and other outerwear'
            ],
            [
                'name' => 'Accessories',
                'description' => 'Bags, scarves, and other accessories'
            ]
        ];

        foreach ($categories as $categoryData) {
            // Create unique slug
            $slug = Str::slug($categoryData['name']);
            $categoryData['slug'] = $this->makeUniqueSlug($slug);
            
            Category::create($categoryData);
        }
    }
    
    /**
     * Generate a unique slug
     */
    private function makeUniqueSlug($slug)
    {
        $original = $slug;
        $count = 2;
        
        while (Category::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$count}";
            $count++;
        }
        
        return $slug;
    }
} 