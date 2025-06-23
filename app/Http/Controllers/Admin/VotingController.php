<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voting;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notification;


class VotingController extends Controller
{
    // Admin - View all votings
    public function index()
    {
        $votings = Voting::latest()->paginate(5);
        $now = now();

        foreach ($votings as $voting) {
            $start = $voting->start_date && $voting->start_time
                ? \Carbon\Carbon::parse("{$voting->start_date} {$voting->start_time}")
                : \Carbon\Carbon::parse($voting->start_date);

            $end = $voting->end_date && $voting->end_time
                ? \Carbon\Carbon::parse("{$voting->end_date} {$voting->end_time}")
                : \Carbon\Carbon::parse($voting->end_date);

            if ($now->between($start, $end) && $voting->status !== 'active') {
                $voting->status = 'active';
                $voting->save();
            }

            if ($now->gt($end) && $voting->status !== 'inactive') {
                $voting->status = 'inactive';
                $voting->save();
            }
        }

        return view('admin.votings.index', compact('votings'));
    }


    // Admin - Show form to create new voting
    public function create()
    {
        return view('admin.votings.create');
    }

    // Admin - Store a new voting
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            
            'choices' => 'required|array|min:1',
            'choices.*' => 'required|string|max:255',
        ]);

        // Combine start & end datetime manually
        $start = $request->start_date && $request->start_time
            ? \Carbon\Carbon::parse("{$request->start_date} {$request->start_time}")
            : \Carbon\Carbon::parse($request->start_date);

        $end = $request->end_date && $request->end_time
            ? \Carbon\Carbon::parse("{$request->end_date} {$request->end_time}")
            : \Carbon\Carbon::parse($request->end_date);

        if ($end->lt($start)) {
            return back()->withErrors(['end_time' => 'The end datetime must be after the start datetime.'])->withInput();
        }

        $voting = Voting::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'inactive',
        ]);

        foreach ($request->choices as $choiceName) {
            $voting->choices()->create(['name' => $choiceName]);
        }

        // Notify all users
        $users = User::all();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'New Voting Session Open',
                'message' => "A new voting titled '{$voting->title}' is now available. Cast your vote before it ends!",
                'read' => false,
            ]);
        }

        return redirect()->route('admin.votings.index')->with('success', 'Voting created successfully.');
    }



    // Admin - Show specific voting (and maybe view votes)
    public function show(Voting $voting)
    {
        $votes = $voting->votes()->with('user')->get();

        $totalVotes = $votes->count();

        $results = $voting->choices->map(function ($choice) use ($totalVotes) {
            $voteCount = $choice->votes()->count();
            $percentage = $totalVotes > 0 ? round(($voteCount / $totalVotes) * 100, 1) : 0;
            return [
                'name' => $choice->name,
                'votes' => $voteCount,
                'percentage' => $percentage,
            ];
        });

        return view('admin.votings.show', compact('voting', 'votes', 'results'));
    }

    // Admin - Edit voting
    public function edit(Voting $voting)
    {
        return view('admin.votings.edit', compact('voting'));
    }

    // Admin - Update voting
    public function update(Request $request, Voting $voting)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'choices' => 'required|array|min:1',
            'choices.*' => 'required|string|max:255',
        ]);

        $start = $request->start_date && $request->start_time
            ? \Carbon\Carbon::parse("{$request->start_date} {$request->start_time}")
            : \Carbon\Carbon::parse($request->start_date);

        $end = $request->end_date && $request->end_time
            ? \Carbon\Carbon::parse("{$request->end_date} {$request->end_time}")
            : \Carbon\Carbon::parse($request->end_date);

        if ($end->lt($start)) {
            return back()->withErrors(['end_time' => 'The end datetime must be after the start datetime.'])->withInput();
        }


        $start_time = $request->start_time ? \Carbon\Carbon::parse($request->start_time)->format('H:i') : null;
        $end_time = $request->end_time ? \Carbon\Carbon::parse($request->end_time)->format('H:i') : null;

        $voting->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time, // no need to re-format
            'end_time' => $request->end_time,
            'status' => 'inactive',

        ]);

        // Replace all existing choices
        $voting->choices()->delete();
        foreach ($request->choices as $choiceName) {
            $voting->choices()->create(['name' => $choiceName]);
        }

        return redirect()->route('admin.votings.index')->with('success', 'Voting updated.');
    }


    // Admin - Delete voting
    public function destroy(Voting $voting)
    {
        $voting->delete();
        return redirect()->route('admin.votings.index')->with('success', 'Voting deleted.');
    }

    public function endVoting(Voting $voting)
    {
        if ($voting->status === 'inactive') {
            return back()->with('info', 'Voting is already inactive.');
        }

        $votes = $voting->votes;
        $totalVotes = $votes->count();

        // Determine winning choice
        $winningChoice = null;
        if ($totalVotes > 0) {
            $winningChoice = $voting->choices
                ->map(function ($choice) {
                    return [
                        'name' => $choice->name,
                        'count' => $choice->votes()->count()
                    ];
                })
                ->sortByDesc('count')
                ->first();
        }

        // Send result notification to all users
        $users = User::all();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => '🗳️ Voting Ended',
                'message' => $totalVotes > 0
                    ? "The voting '{$voting->title}' has ended. The winning choice was '{$winningChoice['name']}' with {$winningChoice['count']} vote(s)."
                    : "The voting '{$voting->title}' has ended. No votes were cast.",
                'read' => false,
            ]);
        }

        $voting->status = 'inactive';
        $voting->save();

        return redirect()->route('admin.votings.index')->with('success', 'Voting ended and users notified.');
    }

}
