<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $upcomingEvents = Event::whereDate('date', '>=', $today)
            ->orderBy('date')
            ->paginate(6, ['*'], 'upcoming');

        $pastEvents = Event::whereDate('date', '<', $today)
            ->orderBy('date', 'desc')
            ->paginate(6, ['*'], 'past');

        $latestEvents = Event::latest()->take(5)->get();

        return view('user.events.index', compact('upcomingEvents', 'pastEvents', 'latestEvents'));
    }



    public function show($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        return view('user.events.show', compact('event'));
    }

}
