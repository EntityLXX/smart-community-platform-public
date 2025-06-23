<?php
use App\Models\User;
use App\Models\Event;
use Carbon\Carbon;
use function Pest\Laravel\{actingAs, get};

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    actingAs($this->user);
});

// Test: User can access the event listing page
test('user can access the event listing page', function () {
    get(route('user.events.index'))->assertOk();
});

// Test: Event index separates upcoming and past events
test('event index separates upcoming and past events correctly', function () {
    Event::factory()->create(['date' => Carbon::today()->addDay()]);
    Event::factory()->create(['date' => Carbon::today()->subDay()]);

    $response = get(route('user.events.index'));
    $response->assertOk()
             ->assertSee('Upcoming')
             ->assertSee('Past');
});

// Test: User can view details of an event
test('user can view event details', function () {
    $event = Event::factory()->create([
        'event_name' => 'Community Gathering',
        'date' => now()->addDays(2)->toDateString()
    ]);

    get(route('user.events.show', $event->id))
        ->assertOk()
        ->assertSee('Community Gathering');
});

// Test: Non-existent event returns 404
test('viewing a non-existent event returns 404', function () {
    get(route('user.events.show', 9999))->assertNotFound();
});