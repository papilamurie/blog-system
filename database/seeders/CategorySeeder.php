<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'description' => 'Posts about tech, programming, and software', 'color' => '#3b82f6'],
            ['name' => 'Travel', 'description' => 'Travel stories and destination guides', 'color' => '#10b981'],
            ['name' => 'Food', 'description' => 'Recipes, restaurants, and culinary adventures', 'color' => '#f59e0b'],
            ['name' => 'Lifestyle', 'description' => 'Personal stories and life experiences', 'color' => '#ec4899'],
            ['name' => 'Business', 'description' => 'Entrepreneurship and business insights', 'color' => '#6366f1'],
            ['name' => 'Health', 'description' => 'Fitness, wellness, and health tips', 'color' => '#ef4444'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categories seeded successfully!');
    }
}
