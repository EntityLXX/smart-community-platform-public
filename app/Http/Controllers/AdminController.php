<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\FacilityBooking;
use App\Models\Voting;
use App\Models\Notification;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        $eventCount = Event::where('created_at', '>=', $startOfMonth)->count();
        $bookingCount = FacilityBooking::where('created_at', '>=', $startOfMonth)->count();
        $votingCount = Voting::where('created_at', '>=', $startOfMonth)->count();
        $unreadNotifications = Notification::where('user_id', auth()->id())
                                           ->where('read', false)
                                           ->count();
    
        return view('admin.dashboard', compact('eventCount', 'bookingCount', 'votingCount', 'unreadNotifications'));

    }
}
