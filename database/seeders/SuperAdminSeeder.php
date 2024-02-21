<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Salman Farees',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'superadmin',
            'email_verified_at' => now(), // Set the current timestamp for email verification
            'remember_token' => Str::random(10), // Generate a random remember token
            'created_at' => now(), // Set the current timestamp for creation
            'updated_at' => now(), // Set the current timestamp for update
        ]);
    }
}
