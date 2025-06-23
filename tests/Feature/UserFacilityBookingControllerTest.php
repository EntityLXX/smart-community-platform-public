<?php

use App\Models\User;
use App\Models\FacilityBooking;
use Illuminate\Support\Carbon;
use function Pest\Laravel\{actingAs, get, post, delete, assertDatabaseHas, assertDatabaseMissing};

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->otherUser = User::factory()->create(['role' => 'user']);
    actingAs($this->user);
});

// User can access the booking list page
test('user can view their booking list', function () {
    FacilityBooking::factory()->create(['user_id' => $this->user->id]);
    get(route('user.facility-bookings.index'))->assertOk()->assertSee('Booking');
});

// User can access the booking creation form
test('user can access the booking creation form', function () {
    get(route('user.facility-bookings.create'))->assertOk();
});

// User can store a valid booking request
test('user can submit a valid booking request', function () {
    $response = post(route('user.facility-bookings.store'), [
        'facility' => 'Main Hall',
        'purpose' => 'Birthday Event',
        'date' => now()->addDays(2)->toDateString(),
        'start_time' => '10:00',
        'end_time' => '12:00',
    ]);

    $response->assertRedirect(route('user.facility-bookings.index'));
    assertDatabaseHas('facility_bookings', [
        'facility' => 'Main Hall',
        'purpose' => 'Birthday Event',
        'user_id' => $this->user->id,
    ]);
});

// Validation fails if required fields are missing
test('booking store fails if fields are missing', function () {
    post(route('user.facility-bookings.store'), [])
        ->assertSessionHasErrors(['facility', 'purpose', 'date', 'start_time', 'end_time']);
});

// User can view their own booking details
test('user can view details of their own booking', function () {
    $booking = FacilityBooking::factory()->create(['user_id' => $this->user->id]);
    get(route('user.facility-bookings.show', $booking->id))->assertOk()->assertSee($booking->purpose);
});

// User cannot view booking of another user
test('user cannot view booking of another user', function () {
    $booking = FacilityBooking::factory()->create(['user_id' => $this->otherUser->id]);
    get(route('user.facility-bookings.show', $booking->id))->assertNotFound();
});

// User can delete their own booking
test('user can delete their own booking', function () {
    $booking = FacilityBooking::factory()->create(['user_id' => $this->user->id]);
    delete(route('user.facility-bookings.destroy', $booking->id))
        ->assertRedirect(route('user.facility-bookings.index'));
    assertDatabaseMissing('facility_bookings', ['id' => $booking->id]);
});

// User cannot delete another user’s booking
test('user cannot delete another user booking', function () {
    $booking = FacilityBooking::factory()->create(['user_id' => $this->otherUser->id]);
    delete(route('user.facility-bookings.destroy', $booking->id))->assertForbidden();
    assertDatabaseHas('facility_bookings', ['id' => $booking->id]);
});