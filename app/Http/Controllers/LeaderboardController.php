<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function coachShow(Challenge $challenge)
    {
        $leaderboard = $this->getLeaderboard($challenge);

        return view('coach.leaderboards.show', compact(
            'challenge',
            'leaderboard'
        ));
    }

    public function publish(Request $request, Challenge $challenge)
    {
        $challenge->update([
            'leaderboard_published' => true,
        ]);

        return back()->with(
            'success',
            'Het leaderboard is gepubliceerd.'
        );
    }

    public function unpublish(Request $request, Challenge $challenge)
    {
        $challenge->update([
            'leaderboard_published' => false,
        ]);

        return back()->with(
            'success',
            'Het leaderboard is niet meer gepubliceerd.'
        );
    }

    public function memberShow(Challenge $challenge)
    {
        if (!$challenge->leaderboard_published) {
            abort(404);
        }

        $leaderboard = $this->getLeaderboard($challenge);

        return view('member.leaderboards.show', compact(
            'challenge',
            'leaderboard'
        ));
    }

    private function getLeaderboard(Challenge $challenge)
    {
        return $challenge->participations()
            ->with([
                'user',
                'results' => function ($query) {
                    $query->where('status', 'approved')
                        ->orderByDesc('value');
                },
            ])
            ->get()
            ->map(function ($participation) {
                $bestResult = $participation->results->first();

                if (!$bestResult) {
                    return null;
                }

                return [
                    'user' => $participation->user,
                    'result' => $bestResult,
                    'value' => $bestResult->value,
                ];
            })
            ->filter()
            ->sortByDesc('value')
            ->values();
    }
}