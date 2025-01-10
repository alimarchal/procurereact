<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'customer_id' => Customer::factory(),
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->boolean(),
        ];
    }
}
