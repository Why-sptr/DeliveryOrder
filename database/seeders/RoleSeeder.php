<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Tambahkan role
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Tambahkan admin default
        $admin = \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $admin->assignRole('admin');

        $admin = \App\Models\User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $admin->assignRole('user');
    }
}
