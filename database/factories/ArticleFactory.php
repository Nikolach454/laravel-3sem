<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $authorName = fake()->name();

        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraphs(5, true),
            'author' => $authorName,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
