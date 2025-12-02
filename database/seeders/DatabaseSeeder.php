<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@blog.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Regular User
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'user@blog.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Technology', 'description' => 'Latest tech news and tutorials'],
            ['name' => 'Lifestyle', 'description' => 'Tips for better living'],
            ['name' => 'Travel', 'description' => 'Travel guides and stories'],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[] = \App\Models\Category::create($cat);
        }

        // Create Tags
        $tags = ['Laravel', 'PHP', 'Web Development', 'Tutorial', 'Tips', 'Guide'];
        $createdTags = [];
        foreach ($tags as $tag) {
            $createdTags[] = \App\Models\Tag::create(['name' => $tag]);
        }

        // Create Posts
        for ($i = 1; $i <= 10; $i++) {
            $post = \App\Models\Post::create([
                'user_id' => $admin->id,
                'category_id' => $createdCategories[array_rand($createdCategories)]->id,
                'title' => 'Sample Blog Post #' . $i,
                'content' => '<h2>Introduction</h2><p>This is a sample blog post content with HTML formatting. ' .
                    'Laravel makes it easy to build powerful web applications.</p>' .
                    '<h2>Main Content</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. ' .
                    'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                'excerpt' => 'This is a brief excerpt of the blog post #' . $i,
                'status' => 'published',
                'publish_at' => now()->subDays(rand(1, 30)),
                'meta_title' => 'Sample Blog Post #' . $i,
                'meta_description' => 'Meta description for sample post #' . $i,
                'views_count' => rand(10, 500),
            ]);

            // Attach random tags
            $post->tags()->attach([
                $createdTags[array_rand($createdTags)]->id,
                $createdTags[array_rand($createdTags)]->id,
            ]);

            // Create Comments
            for ($j = 1; $j <= rand(2, 5); $j++) {
                \App\Models\Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'content' => 'This is a sample comment #' . $j . ' on post #' . $i,
                    'status' => 'approved',
                ]);
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin Email: admin@blog.com');
        $this->command->info('Admin Password: password');
        $this->command->info('User Email: user@blog.com');
        $this->command->info('User Password: password');
    }
}
