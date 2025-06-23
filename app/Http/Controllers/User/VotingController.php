<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Voting;
use App\Models\Vote;

class VotingController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $votings = Voting::with('choices')
            ->latest()
            ->paginate(5);

        $now = now();

        foreach ($votings as $voting) {
            $start = $voting->start_date && $voting->start_time
                ? \Carbon\Carbon::parse("{$voting->start_date} {$voting->start_time}")
                : \Carbon\Carbon::parse($voting->start_date);

            $end = $voting->end_date && $voting->end_time
                ? \Carbon\Carbon::parse("{$voting->end_date} {$voting->end_time}")
                : \Carbon\Carbon::parse($voting->end_date);

            // Automatically activate if current time is within voting period
            if ($now->between($start, $end) && $voting->status !== 'active') {
                $voting->status = 'active';
                $voting->save();
            }

            // Automatically deactivate if current time has passed the end
            if ($now->gt($end) && $voting->status !== 'inactive') {
                $voting->status = 'inactive';
                $voting->save();
            }

            // Additional calculated attributes for UI
            $voting->isAvailable = $voting->status === 'active' && $now->between($start, $end);
            $voting->hasVoted = $voting->votes()->where('user_id', $userId)->exists();

            $totalVotes = $voting->votes()->count();
            $voting->results = $voting->choices->map(function ($choice) use ($totalVotes) {
                $voteCount = $choice->votes()->count();
                $percentage = $totalVotes > 0 ? round(($voteCount / $totalVotes) * 100, 1) : 0;
                return [
                    'name' => $choice->name,
                    'votes' => $voteCount,
                    'percentage' => $percentage,
                ];
            });
        }

        return view('user.votings.index', compact('votings'));
    }

    public function show(Voting $voting)
    {
        $userId = Auth::id();
        $now = now();

        $start = $voting->start_date && $voting->start_time
            ? \Carbon\Carbon::parse("{$voting->start_date} {$voting->start_time}")
            : \Carbon\Carbon::parse($voting->start_date);

        $end = $voting->end_date && $voting->end_time
            ? \Carbon\Carbon::parse("{$voting->end_date} {$voting->end_time}")
            : \Carbon\Carbon::parse($voting->end_date);

        // Determine actual availability based on time
        $isAvailable = $voting->status === 'active' && $now->between($start, $end);

        // Check if user has voted
        $hasVoted = Vote::where('voting_id', $voting->id)
            ->where('user_id', $userId)
            ->exists();

        // Get results for all
        $totalVotes = $voting->votes()->count();
        $results = $voting->choices->map(function ($choice) use ($totalVotes) {
            $voteCount = $choice->votes()->count();
            $percentage = $totalVotes > 0 ? round(($voteCount / $totalVotes) * 100, 1) : 0;
            return [
                'name' => $choice->name,
                'votes' => $voteCount,
                'percentage' => $percentage,
            ];
        });

        return view('user.votings.show', compact('voting', 'hasVoted', 'results', 'isAvailable'));
    }


    public function vote(Request $request, Voting $voting)
    {
        // Validate the selected choice
        $request->validate([
            'choice_id' => 'required|exists:choices,id'
        ]);

        $userId = Auth::id();

        // Check if the vote already exists
        $existingVote = Vote::where('voting_id', $voting->id)
            ->where('user_id', $userId)
            ->first();

        if ($existingVote) {
            $existingVote->choice_id = $request->choice_id;
            $existingVote->save();
            $message = 'Your vote has been updated.';
        } else {
            Vote::create([
                'voting_id' => $voting->id,
                'user_id' => $userId,
                'choice_id' => $request->choice_id,
            ]);
            $message = 'Your vote has been recorded.';
        }

        return redirect()->route('user.votings.index')->with('success', $message);
    }

}
