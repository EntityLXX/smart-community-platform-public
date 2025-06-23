<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacilityBooking;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;


class FacilityBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = FacilityBooking::latest()->paginate(5);
        return view('admin.facility-bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = FacilityBooking::findOrFail($id);
        return view('admin.facility-bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function approve($id, Request $request)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:255',
        ]);

        $booking = FacilityBooking::findOrFail($id);

        $booking->status = 'approved';
        $booking->admin_notes = $request->input('admin_notes');
        $booking->save();

        // Notify the user
        Notification::create([
            'user_id' => $booking->user_id,
            'title' => 'Facility Booking Approved',
            'message' => "Your booking for {$booking->facility} on {$booking->date} from {$booking->start_time} to {$booking->end_time} has been approved.",
            'read' => false,
        ]);

        return redirect()->route('admin.facility-bookings.index')->with('success', 'Booking approved successfully!');
    }

    public function reject($id, Request $request)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:255',
        ]);

        $booking = FacilityBooking::findOrFail($id);
        $booking->status = 'rejected';
        $booking->admin_notes = $request->input('admin_notes');
        $booking->save();

        // Notify the booking user
        Notification::create([
            'user_id' => $booking->user_id,
            'title' => 'Facility Booking Rejected',
            'message' => "Your booking for {$booking->facility} on {$booking->date} at {$booking->time} has been rejected. Notes: {$booking->admin_notes}",
            'read' => false,
        ]);

        return redirect()->route('admin.facility-bookings.index')->with('success', 'Booking rejected.');
    }


    public function calendarData()
    {
        $bookings = FacilityBooking::with('user')->get();

        $events = $bookings->map(function ($booking) {
            $color = match ($booking->status) {
                'approved' => '#22c55e',  // green
                'pending' => '#eab308',   // yellow
                'rejected' => '#ef4444',  // red
            };

            return [
                'title' => $booking->facility . ' (by ' . $booking->user->name . ')',
                'start' => Carbon::parse($booking->date . ' ' . $booking->start_time)->toIso8601String(),
                'end' => Carbon::parse($booking->date . ' ' . $booking->end_time)->toIso8601String(),
                'color' => $color,
                'extendedProps' => [
                    'user' => $booking->user->name,
                    'purpose' => $booking->purpose,
                    'status' => $booking->status,
                    'notes' => $booking->admin_notes,
                ],
            ];
        });

        return response()->json($events);
    }


}
