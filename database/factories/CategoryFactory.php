<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_id' => Company::factory(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'status' => true,
        ];
    }
}
