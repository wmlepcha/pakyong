<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(3), 'title' => fake()->sentence(4), 'category' => 'Planning', 'excerpt' => fake()->sentence(), 'intro' => fake()->paragraph(),
            'sections' => [['heading' => 'First part', 'paragraphs' => [fake()->paragraph(), fake()->paragraph()]]], 'image' => 'site/east.webp', 'published_at' => now()->subDay()->toDateString(), 'is_published' => true,
        ];
    }
}
