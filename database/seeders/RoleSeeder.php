<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'User',
            'Admin',
            'Super Admin',
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
            ]);
        }
    }
}
