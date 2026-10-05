<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Participation;
use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function create(Request $request, Challenge $challenge)
    {
        $participation = Participation::where('user_id', $request->user()->id)
            ->where('challenge_id', $challenge->id)
            ->firstOrFail();

        return view('member.results.create', compact(
            'challenge',
            'participation'
        ));
    }

    public function store(Request $request, Challenge $challenge)
    {
        $participation = Participation::where('user_id', $request->user()->id)
            ->where('challenge_id', $challenge->id)
            ->firstOrFail();

        $validated = $request->validate([
            'result_date' => [
                'required',
                'date',
                'after_or_equal:' . $challenge->start_date->format('Y-m-d'),
                'before_or_equal:' . $challenge->end_date->format('Y-m-d'),
            ],
            'value' => [
                'required',
                'numeric',
                'min:' . $challenge->min_value,
                'max:' . $challenge->max_value,
            ],
            'proof_url' => [
                'required',
                'url',
                'max:2048',
            ],
        ], [
            'result_date.required' => 'Vul een datum in.',
            'result_date.after_or_equal' => 'De datum mag niet vóór de start van de challenge liggen.',
            'result_date.before_or_equal' => 'De datum mag niet na het einde van de challenge liggen.',

            'value.required' => 'Vul een resultaat in.',
            'value.numeric' => 'Het resultaat moet een getal zijn.',
            'value.min' => 'Het resultaat moet minimaal ' . $challenge->min_value . ' ' . $challenge->unit . ' zijn.',
            'value.max' => 'Het resultaat mag maximaal ' . $challenge->max_value . ' ' . $challenge->unit . ' zijn.',

            'proof_url.required' => 'Vul een bewijslink in.',
            'proof_url.url' => 'Vul een geldige bewijslink in.',
            'proof_url.max' => 'De bewijslink is te lang.',
        ]);

        Result::create([
            'participation_id' => $participation->id,
            'result_date' => $validated['result_date'],
            'value' => $validated['value'],
            'proof_url' => $validated['proof_url'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('member.dashboard')
            ->with(
                'success',
                'Je resultaat voor ' . $challenge->name . ' is ingediend en wacht op beoordeling.'
            );
    }
}