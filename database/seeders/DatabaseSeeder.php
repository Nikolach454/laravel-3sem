<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ModeratorSeeder::class,
        ]);

        \App\Models\Article::factory(10)->create()->each(function ($article) {
            \App\Models\Comment::factory(rand(2, 5))->create([
                'article_id' => $article->id
            ]);
        });
    }
}
