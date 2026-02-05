<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Laravel',
            'PHP',
            'JavaScript',
            'Tutorial',
            'Web Development',
            'Mobile',
            'Design',
            'Tips',
            'Guide',
            'Review',
            'News',
            'Opinion',
        ];

        foreach ($tags as $tagName) {
            $slug = Str::slug($tagName);

            Tag::updateOrCreate(
                ['slug' => $slug],  // Match by slug
                ['name' => $tagName, 'slug' => $slug]  // Update/create with this data
            );
        }

        $this->command->info('Tags seeded successfully!');
    }
}
