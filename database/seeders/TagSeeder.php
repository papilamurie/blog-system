<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

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

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }

        $this->command->info('Tags seeded successfully!');
    }
}
