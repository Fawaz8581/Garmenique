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
                'name' => 'T-shirt',
                'description' => 'Casual short-sleeved t-shirts'
            ],
            [
                'name' => 'Shirt',
                'description' => 'Formal and casual long-sleeved shirts'
            ],
            [
                'name' => 'Jackets',
                'description' => 'Outerwear jackets and coats'
            ],
            [
                'name' => 'Pants',
                'description' => 'Formal and casual pants'
            ],
            [
                'name' => 'Hoodie',
                'description' => 'Hooded sweatshirts and pullovers'
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