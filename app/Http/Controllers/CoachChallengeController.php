<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;

class CoachChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::orderByDesc('start_date')->get();

        return view('coach.challenges.index', compact('challenges'));
    }

    public function create()
    {
        return view('coach.challenges.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'rules' => ['required', 'string'],
            'min_value' => ['required', 'numeric', 'min:0'],
            'max_value' => ['required', 'numeric', 'gt:min_value'],
        ], [
            'name.required' => 'Vul een naam in.',
            'unit.required' => 'Vul een eenheid in.',
            'start_date.required' => 'Vul een startdatum in.',
            'end_date.required' => 'Vul een einddatum in.',
            'end_date.after_or_equal' => 'De einddatum moet op of na de startdatum liggen.',
            'rules.required' => 'Vul de regels van de challenge in.',
            'min_value.required' => 'Vul een minimumwaarde in.',
            'min_value.numeric' => 'De minimumwaarde moet een getal zijn.',
            'min_value.min' => 'De minimumwaarde mag niet negatief zijn.',
            'max_value.required' => 'Vul een maximumwaarde in.',
            'max_value.numeric' => 'De maximumwaarde moet een getal zijn.',
            'max_value.gt' => 'De maximumwaarde moet hoger zijn dan de minimumwaarde.',
        ]);

        Challenge::create([
            'created_by' => $request->user()->id,
            'name' => $validated['name'],
            'unit' => $validated['unit'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'rules' => $validated['rules'],
            'min_value' => $validated['min_value'],
            'max_value' => $validated['max_value'],
            'leaderboard_published' => false,
        ]);

        return redirect()
            ->route('coach.challenges.index')
            ->with('success', 'Challenge is succesvol aangemaakt.');
    }

    public function edit(Challenge $challenge)
    {
        return view('coach.challenges.edit', compact('challenge'));
    }

    public function update(Request $request, Challenge $challenge)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'rules' => ['required', 'string'],
            'min_value' => ['required', 'numeric', 'min:0'],
            'max_value' => ['required', 'numeric', 'gt:min_value'],
        ], [
            'name.required' => 'Vul een naam in.',
            'unit.required' => 'Vul een eenheid in.',
            'start_date.required' => 'Vul een startdatum in.',
            'end_date.required' => 'Vul een einddatum in.',
            'end_date.after_or_equal' => 'De einddatum moet op of na de startdatum liggen.',
            'rules.required' => 'Vul de regels van de challenge in.',
            'min_value.required' => 'Vul een minimumwaarde in.',
            'min_value.numeric' => 'De minimumwaarde moet een getal zijn.',
            'min_value.min' => 'De minimumwaarde mag niet negatief zijn.',
            'max_value.required' => 'Vul een maximumwaarde in.',
            'max_value.numeric' => 'De maximumwaarde moet een getal zijn.',
            'max_value.gt' => 'De maximumwaarde moet hoger zijn dan de minimumwaarde.',
        ]);

        $challenge->update($validated);

        return redirect()
            ->route('coach.challenges.index')
            ->with('success', 'Challenge is succesvol bijgewerkt.');
    }

    public function destroy(Challenge $challenge)
    {
        $challenge->delete();

        return redirect()
            ->route('coach.challenges.index')
            ->with('success', 'Challenge is verwijderd.');
    }
}