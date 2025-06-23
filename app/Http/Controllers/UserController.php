<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\FacilityBooking;
use App\Models\Voting;
use App\Models\Notification;
use Carbon\Carbon;


class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $startOfMonth = Carbon::now()->startOfMonth();

        $eventCount = Event::where('created_at', '>=', $startOfMonth)->count(); // Optional: filter by relevant participation if implemented
        $bookingCount = $user->facilityBookings()->where('created_at', '>=', $startOfMonth)->count();
        $votingCount = $user->votes()->where('created_at', '>=', $startOfMonth)->count();
        $unreadNotifications = $user->notifications()->where('read', false)->count();

        return view('user.dashboard', compact('eventCount', 'bookingCount', 'votingCount', 'unreadNotifications'));
    }
}
