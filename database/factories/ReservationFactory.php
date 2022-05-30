<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateFrom = $this->faker->date();
        $dateTo = $this->faker->dateTimeBetween($dateFrom, '+20 days')->format('Y-m-d');
        return [
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'room_id' => rand(1, 500),
            'user_id' => rand(1, 10),
        ];
    }
}
