<?php

namespace Database\Factories;

use App\Models\TherapistProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TherapistProfile>
 */
class TherapistProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        $slug = Str::slug($firstName . ' ' . $lastName) . '-' . Str::random(6);

        return [
            'slug' => $slug,
            'about' => fake()->paragraphs(3, true),
            'notes' => fake()->optional()->sentence(),
            'health_renewal_date' => fake()->optional()->dateTime(),
            'health_professional' => fake()->boolean(30),
            'extend_cost' => fake()->optional()->randomFloat(2, 10, 50),
            'fee_therapist_60' => 60,
            'fee_therapist_90' => 90,
            'fee_therapist_120' => 120,
            'fee_therapist_150' => 150,
            'fee_therapist_180' => 180,
            'fee_therapist_210' => 210,
            'on_therapist_page' => fake()->boolean(60),
            'soothing' => fake()->boolean(50),
            'strong' => fake()->boolean(50),
            'z_chair' => fake()->boolean(40),
            'massage_table' => fake()->boolean(60),
            'gender' => fake()->boolean(),
            'avg_rating' => fake()->optional()->randomFloat(1, 3.5, 5.0),
            'bonus_eligible' => fake()->optional()->boolean(70),
            'bonus_amount' => fake()->optional()->randomFloat(2, 0, 500),
            'page_meta_title' => 'Professional Therapist - ' . $firstName . ' ' . $lastName,
            'page_meta_tag' => fake()->words(10, true),
            'extra_meta_tags' => fake()->optional()->words(5, true),
        ];
    }

    /**
     * Indicate that the therapist is featured on therapist page.
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'on_therapist_page' => true,
            'avg_rating' => fake()->randomFloat(1, 4.0, 5.0),
        ]);
    }

    /**
     * Indicate that the therapist is eligible for bonus.
     */
    public function withBonus(): static
    {
        return $this->state(fn(array $attributes) => [
            'bonus_eligible' => true,
            'bonus_amount' => fake()->randomFloat(2, 50, 500),
        ]);
    }

    /**
     * Indicate that the therapist is a health professional.
     */
    public function healthProfessional(): static
    {
        return $this->state(fn(array $attributes) => [
            'health_professional' => true,
            'health_renewal_date' => now()->addMonths(fake()->numberBetween(1, 12)),
        ]);
    }
}
