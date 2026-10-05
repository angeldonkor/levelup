<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Participation;
use Illuminate\Http\Request;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $activeChallenges = Challenge::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->with([
                'participations' => function ($query) {
                    $query->where('user_id', auth()->id());
                },
            ])
            ->orderBy('end_date')
            ->get();

        return view('member.dashboard', compact('activeChallenges'));
    }

    public function join(Request $request, Challenge $challenge)
    {
        if (
            $challenge->start_date->isAfter(today()) ||
            $challenge->end_date->isBefore(today())
        ) {
            return back()->withErrors([
                'challenge' => 'Je kunt alleen deelnemen aan een actieve challenge.',
            ]);
        }

        Participation::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'challenge_id' => $challenge->id,
            ],
            [
                'joined_at' => now(),
            ]
        );

        return back()->with(
            'success',
            'Je neemt nu deel aan ' . $challenge->name . '.'
        );
    }

    public function progress(Request $request)
    {
        $participations = Participation::where('user_id', $request->user()->id)
            ->with([
                'challenge',
                'results' => function ($query) {
                    $query->orderByDesc('result_date')
                        ->orderByDesc('created_at');
                },
            ])
            ->orderByDesc('joined_at')
            ->get();

        return view('member.progress', compact('participations'));
    }
}