<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraph(nbSentences: 5),
            'image' => $this->faker->imageUrl(640, 480, 'house'),
            'place' => $this->faker->city(),
            'accommodationType' => ['holet', 'pensjonat', 'Kwatera prywata'][rand(0, 2)],
            'user_id' => rand(1, 10),
        ];
    }
}
