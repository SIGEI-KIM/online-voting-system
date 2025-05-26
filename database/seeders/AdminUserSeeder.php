<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Add this line
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // AdminUserSeeder.php
        User::create([
            'name' => 'Admin',
            'email' => 'admin@voting.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}