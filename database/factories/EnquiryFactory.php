<?php

namespace Database\Factories;

use App\Models\Enquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enquiry>
 */
class EnquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Pema Lepcha', 'phone' => '7478127403', 'destinations' => ['East Sikkim'], 'tier' => 'Standard', 'traveller' => 'Indian visitor', 'season' => 'Peak season',
            'start_date' => now()->addDays(30)->toDateString(), 'days' => 5, 'people' => 2, 'stay' => 'Hotels', 'status' => 'new',
        ];
    }
}
