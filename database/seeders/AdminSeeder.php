<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrateur',
                'email' => 'admin@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('admin'),
                'role' => 'admin',
            ]
        );

        \App\Models\User::updateOrCreate(
            ['username' => 'manager'],
            [
                'name' => 'Manager Test',
                'email' => 'manager@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('manager'),
                'role' => 'manager',
            ]
        );

        \App\Models\User::updateOrCreate(
            ['username' => 'user'],
            [
                'name' => 'Utilisateur Test',
                'email' => 'user@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('user'),
                'role' => 'user',
            ]
        );
    }
}
