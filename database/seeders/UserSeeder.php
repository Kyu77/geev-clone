<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();
       // $role = Role::query()->first();

        User::query()->create([
            'name' => 'Administrator',
            'email' => 'admin@root.com',
            'password' => "admin123",
            'role' => 'ADMIN'
            ]);
    }
}
