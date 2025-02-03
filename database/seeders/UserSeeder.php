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
        $role = Role::query()->first();

        User::query()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => "0123456789",
            "role_id" => $role->id,
        ]);
    }
}
