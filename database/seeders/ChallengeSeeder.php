<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $coach = User::where('email', 'coach@levelup.test')->firstOrFail();

        Challenge::updateOrCreate(
            ['name' => 'October Running Challenge'],
            [
                'created_by' => $coach->id,
                'unit' => 'km',
                'start_date' => '2026-10-01',
                'end_date' => '2026-10-31',
                'rules' => 'Loop zoveel mogelijk kilometers gedurende de maand oktober.',
                'min_value' => 1,
                'max_value' => 50,
                'leaderboard_published' => false,
            ]
        );

        Challenge::updateOrCreate(
            ['name' => 'Push-up Challenge'],
            [
                'created_by' => $coach->id,
                'unit' => 'herhalingen',
                'start_date' => '2026-10-01',
                'end_date' => '2026-10-20',
                'rules' => 'Voer zoveel mogelijk correcte push-ups uit in één poging.',
                'min_value' => 1,
                'max_value' => 200,
                'leaderboard_published' => false,
            ]
        );
    }
}