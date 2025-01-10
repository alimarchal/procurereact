<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_id' => Company::factory(),
            'category_id' => Category::factory(),
            'code' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{4}'),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'unit' => $this->faker->randomElement(['Pcs', 'Box', 'Kg', 'L']),
            'quantity' => $this->faker->numberBetween(1, 100),
            'unit_price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(0, 200),
            'is_active' => true,
        ];
    }
}
