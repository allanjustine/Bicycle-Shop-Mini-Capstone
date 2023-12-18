<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrator',
            'address' => fake()->address,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ])->assignRole('Admin', 'User')
            ->givePermissionTo('manage-all', 'customer',);

        User::factory()->create([
            'name' => 'Test User',
            'address' => fake()->address,
            'email' => 'vanessa@gmail.com',
            'password' => bcrypt('password')
        ])->assignRole('User')
            ->givePermissionTo('customer');
    }
}
