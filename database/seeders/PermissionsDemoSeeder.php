<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role1 = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        $role2 = Role::create(['name' => 'Admin Support', 'guard_name' => 'web']);
        $role3 = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $role4 = Role::create(['name' => 'Team Member', 'guard_name' => 'web']);
        $role5 = Role::create(['name' => 'IBR', 'guard_name' => 'web']);

        $user = \App\Models\User::factory()->create([
            'name' => 'Super-Admin User',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'is_super_admin' =>'Yes',
            'is_active' =>'Yes',
            'type' =>'Super Admin',
        ]);

        // Create wallet for new user
        Wallet::create(['user_id' => $user->id]);

        // php artisan migrate:fresh --seed --seeder=PermissionsDemoSeeder
        $user->assignRole($role1);
    }
}
