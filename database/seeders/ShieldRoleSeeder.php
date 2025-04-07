<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class ShieldRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan permission sudah ada dari shield:generate
        $permissions = Permission::all();

        // Buat role super-admin
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Assign semua permission ke super-admin
        $superAdminRole->syncPermissions($permissions);

        // Buat user default super-admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign role ke user
        $admin->assignRole($superAdminRole);
    }
}
