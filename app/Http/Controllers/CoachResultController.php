<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class CoachResultController extends Controller
{
    public function index()
    {
        $results = Result::with([
            'participation.user',
            'participation.challenge',
            'reviewer',
        ])
            ->orderByDesc('created_at')
            ->get();

        return view('coach.results.index', compact('results'));
    }

    public function updateStatus(Request $request, Result $result)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected,review'],
        ]);

        $result->update([
            'status' => $validated['status'],
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return back()->with(
            'success',
            'De status van het resultaat is bijgewerkt.'
        );
    }
}