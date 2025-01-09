<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->company(),
            'name_arabic' => $this->faker->company(),
            'email' => $this->faker->companyEmail(),
            'cr_number' => $this->faker->numerify('##########'),
            'vat_number' => $this->faker->numerify('###############'),
            'vat_number_arabic' => $this->faker->numerify('###############'),
            'cell' => $this->faker->phoneNumber(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'customer_industry' => $this->faker->randomElement(['Regular', 'Industrial', 'Commercial']),
            'sale_type' => $this->faker->randomElement(['Manual', 'Automated']),
            'language' => 'english',
            'company_type' => 'customer',
            'vat_percentage' => 15.00,
        ];
    }
}
