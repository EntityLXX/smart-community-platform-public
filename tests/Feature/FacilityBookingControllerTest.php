<?php

use function Pest\Laravel\get;
use App\Models\User;
use App\Models\FacilityBooking;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;
use function Pest\Laravel\patch;

use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

test('admin can approve a facility booking and notify the user', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);

    $booking = FacilityBooking::factory()->create([
        'user_id' => $user->id,
        'status' => 'pending',
        'admin_notes' => null,
    ]);

    actingAs($admin);

    $response = patch(route('admin.facility-bookings.approve', $booking->id), [
        'admin_notes' => 'Approved for event',
    ]);

    $response->assertRedirect(route('admin.facility-bookings.index'));

    assertDatabaseHas('facility_bookings', [
        'id' => $booking->id,
        'status' => 'approved',
        'admin_notes' => 'Approved for event',
    ]);

    assertDatabaseHas('notifications', [
        'user_id' => $user->id,
        'title' => 'Facility Booking Approved',
    ]);
});

test('admin can reject a facility booking and notify the user', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['role' => 'user']);

    $booking = FacilityBooking::factory()->create([
        'user_id' => $user->id,
        'status' => 'pending',
        'admin_notes' => null,
    ]);

    actingAs($admin);

    $response = patch(route('admin.facility-bookings.reject', $booking->id), [
        'admin_notes' => 'Facility not available',
    ]);

    $response->assertRedirect(route('admin.facility-bookings.index'));

    assertDatabaseHas('facility_bookings', [
        'id' => $booking->id,
        'status' => 'rejected',
        'admin_notes' => 'Facility not available',
    ]);

    assertDatabaseHas('notifications', [
        'user_id' => $user->id,
        'title' => 'Facility Booking Rejected',
    ]);
});

// View index page
test('admin can access facility booking index page', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    actingAs($admin);

    $response = get(route('admin.facility-bookings.index'));

    $response->assertOk();
    $response->assertViewIs('admin.facility-bookings.index');
});

// View booking details (show)
test('admin can view individual booking details', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $booking = FacilityBooking::factory()->create();
    actingAs($admin);

    $response = get(route('admin.facility-bookings.show', $booking->id));

    $response->assertOk();
    $response->assertViewIs('admin.facility-bookings.show');
    $response->assertViewHas('booking', $booking);
});

// Get calendar data as JSON
test('admin can fetch calendar data json', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    FacilityBooking::factory()->count(2)->create(['status' => 'approved']);
    actingAs($admin);

    $response = get('/admin/facility-bookings/calendar-data');

    $response->assertOk();
    $response->assertJsonStructure([
        '*' => ['title', 'start', 'end', 'color', 'extendedProps'],
    ]);
});
