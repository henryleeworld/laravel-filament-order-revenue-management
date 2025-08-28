<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'created_at' => fake()->dateTimeBetween('-1 year', '-2 month'),
            'updated_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
