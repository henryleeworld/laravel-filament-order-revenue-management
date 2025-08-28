<?php

namespace Database\Factories;

use App\Enums\ProductStatusEnum;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->catchPhrase(),
            'price' => fake()->numberBetween(500, 5000),
            'description' => fake()->realText(),
            'created_at' => fake()->dateTimeBetween('-1 year', '-6 month'),
            'updated_at' => fake()->dateTimeBetween('-5 month', 'now'),
            'status' => fake()->randomElement(ProductStatusEnum::cases()),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'is_active' => fake()->boolean(0.5),
            'company_id' => Company::inRandomOrder()->first()?->id ?? Company::factory(),
        ];
    }
}
