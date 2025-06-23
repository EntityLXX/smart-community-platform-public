<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacilityBooking;

class FacilityBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = FacilityBooking::where('user_id', auth()->id())
            ->latest()
            ->paginate(5);

        return view('user.facility-bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.facility-bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'facility' => 'required|string|max:255',
            'purpose' => 'required|string|max:500',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Add user_id and default status
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        // Save to database
        FacilityBooking::create($validated);

        // Redirect to index with success message
        return redirect()
            ->route('user.facility-bookings.index')
            ->with('success', 'Booking request submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = FacilityBooking::where('id', $id)
            ->where('user_id', auth()->id()) // Prevent viewing others' bookings
            ->firstOrFail();

        return view('user.facility-bookings.show', compact('booking'));
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
        $booking = FacilityBooking::findOrFail($id);

        // Optional: check if it's the current user's booking
        if ($booking->user_id !== auth()->id()) {
            abort(403); // Forbidden
        }

        $booking->delete();

        return redirect()->route('user.facility-bookings.index')
            ->with('success', 'Your booking request has been cancelled.');


    }
}
