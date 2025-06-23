<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Models\Voting;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    public function create(Voting $voting)
    {
        return view('admin.choices.create', compact('voting'));
    }

    public function store(Request $request, Voting $voting)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $voting->choices()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.votings.show', $voting)->with('success', 'Choice added.');
    }

    public function edit(Voting $voting, Choice $choice)
    {
        return view('admin.choices.edit', compact('voting', 'choice'));
    }

    public function update(Request $request, Voting $voting, Choice $choice)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $choice->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.votings.show', $voting)->with('success', 'Choice updated.');
    }

    public function destroy(Voting $voting, Choice $choice)
    {
        $choice->delete();

        return redirect()->route('admin.votings.show', $voting)->with('success', 'Choice deleted.');
    }
}
