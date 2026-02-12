<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'birthday' => fake()->date(),
            'mobile' => fake()->phoneNumber(),
            'postcode' => fake()->postcode(),
            'flat_no' => fake()->buildingNumber(),
            'street_no' => fake()->streetName(),
            'street_name' => fake()->streetAddress(),
            'town' => fake()->city(),
            'avg_rating' => fake()->randomFloat(2, 1, 5),
        ];
    }
}
