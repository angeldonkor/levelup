<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'member@levelup.test'],
            [
                'name' => 'Test Sportlid',
                'password' => Hash::make('LevelUp123!'),
                'role' => 'member',
            ]
        );

        User::updateOrCreate(
            ['email' => 'coach@levelup.test'],
            [
                'name' => 'Test Coach',
                'password' => Hash::make('LevelUp123!'),
                'role' => 'coach',
            ]
        );
    }
}