<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->words(3, true), 'duration' => '5N / 6D', 'image' => 'site/north.webp', 'bullets' => ['Day trip', 'Permits included'], 'is_published' => true, 'sort_order' => 0,
        ];
    }
}
