<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);

        Business::factory()->count(10)->create([
            'user_id' => $user->id
        ]);
    }
}
