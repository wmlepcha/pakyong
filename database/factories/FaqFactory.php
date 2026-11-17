<?php

namespace Database\Factories;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'faq_category_id' => FaqCategory::query()->firstOrCreate(['name' => 'Planning'])->id, 'question' => fake()->unique()->sentence().'?', 'answer' => fake()->paragraph(), 'show_on_home' => false, 'is_published' => true, 'sort_order' => 0,
        ];
    }
}
