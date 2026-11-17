<?php

namespace Database\Factories;

use App\Models\RideRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RideRequest>
 */
class RideRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Karma Sherpa', 'phone' => '9876543210', 'pickup_location' => 'Bagdogra Airport', 'drop_location' => 'MG Marg, Gangtok', 'pickup_district' => 'Siliguri',
            'pickup_date' => now()->addDays(10)->toDateString(), 'car_type' => '4 seater', 'status' => 'new',
        ];
    }
}
