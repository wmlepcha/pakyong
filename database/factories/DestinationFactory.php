<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Destination>
 */
class DestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(2), 'region' => 'Sikkim', 'name' => fake()->unique()->city(), 'short' => 'Test',
            'card_image' => 'site/east.webp', 'tagline' => fake()->sentence(), 'places_line' => 'Gangtok, Tsomgo Lake', 'base' => 'Gangtok', 'days' => '3 days', 'high' => '10,000 ft',
            'good_for' => ['Families'], 'about' => [fake()->paragraph(), fake()->paragraph()], 'calendar' => array_fill(0, 12, 'good'),
            'seasons' => collect(['Spring', 'Monsoon', 'Autumn', 'Winter'])->map(fn ($n) => ['name' => $n, 'months' => 'March - May', 'temp' => '10-20°C', 'mood' => 'Clear', 'text' => fake()->sentence(), 'wear' => ['Jacket']])->all(),
            'pack_always' => ['Photo ID'], 'places' => [['name' => 'Lake', 'type' => 'Lake', 'description' => fake()->sentence(), 'meta' => '2 hours']],
            'getting' => [['route' => 'From Bagdogra', 'detail' => fake()->sentence(), 'time' => '4 hours']], 'permits' => fake()->sentence(), 'stay' => fake()->sentence(),
            'itinerary' => [fake()->sentence()], 'tips' => [fake()->sentence()], 'faqs' => [['q' => 'Is it open?', 'a' => 'Yes.']], 'is_published' => true, 'sort_order' => 0,
        ];
    }
}
