<?php

use App\Models\User;
use App\Models\Event;
use App\Models\Notification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;


beforeEach(function () {
    Storage::fake('public');
});

// Test: Admin can view the event index page
test('admin can view event listing', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    Event::factory()->count(3)->create();

    actingAs($admin);
    get(route('admin.events.index'))->assertOk();
});

// Test: Admin can access the event creation form
test('admin can access event creation form', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin);
    get(route('admin.events.create'))->assertOk();
});

// Test: Admin can store a valid event and notify users
test('admin can store a valid event and notify users', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $users = User::factory()->count(2)->create();
    $file = UploadedFile::fake()->image('event.jpg');

    actingAs($admin);
    post(route('admin.events.store'), [
        'event_name' => 'Community Meeting',
        'description' => 'Monthly community gathering.',
        'date' => now()->addDays(2)->toDateString(),
        'time' => '18:00:00',
        'location' => 'Main Hall',
        'picture' => $file,
    ])->assertRedirect(route('admin.events.index'));

    assertDatabaseHas('events', ['event_name' => 'Community Meeting']);
    Storage::disk('public')->assertExists('event_pictures/' . $file->hashName());

    foreach ($users as $user) {
        assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'title' => 'New Event: Community Meeting',
        ]);
    }
});

// Test: Validation error if required fields are missing during store
test('store fails if required fields are missing', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    actingAs($admin);
    post(route('admin.events.store'), [])
        ->assertSessionHasErrors(['event_name', 'description', 'date', 'time', 'location']);
});

// Test: Admin can access event edit form
test('admin can access event edit form', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $event = Event::factory()->create();

    actingAs($admin);
    get(route('admin.events.edit', $event->id))->assertOk();
});

// Test: Admin can update an event
test('admin can update an event and notify users', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $users = User::factory()->count(2)->create();

    $originalFile = UploadedFile::fake()->image('old.jpg');
    $newFile = UploadedFile::fake()->image('new.jpg');

    // Create original event
    $event = Event::factory()->create([
        'picture' => $originalFile->store('event_pictures', 'public'),
    ]);

    actingAs($admin);

    $response = put(route('admin.events.update', $event->id), [
        'event_name' => 'Updated Event Name',
        'description' => 'Updated Description',
        'date' => now()->addDays(5)->toDateString(),
        'time' => '09:00:00',
        'location' => 'Updated Location',
        'picture' => $newFile,
    ]);

    $response->assertRedirect(route('admin.events.index'));

    assertDatabaseHas('events', [
        'id' => $event->id,
        'event_name' => 'Updated Event Name',
        'location' => 'Updated Location',
    ]);

    Storage::disk('public')->assertMissing($originalFile->hashName());
    Storage::disk('public')->assertExists('event_pictures/' . $newFile->hashName());

    foreach ($users as $user) {
        assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'title' => 'Event Updated: Updated Event Name',
        ]);
    }
});

// Test: Admin can delete an event
test('admin can delete an event and notify users', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $users = User::factory()->count(2)->create();

    $file = UploadedFile::fake()->image('event.jpg');

    $event = Event::factory()->create([
        'event_name' => 'Deletable Event',
        'date' => now()->addDays(2)->toDateString(),
        'picture' => $file->store('event_pictures', 'public'),
    ]);

    actingAs($admin);

    $response = delete(route('admin.events.destroy', $event->id));

    $response->assertRedirect(route('admin.events.index'));

    assertDatabaseMissing('events', ['id' => $event->id]);
    Storage::disk('public')->assertMissing($file->hashName());

    foreach ($users as $user) {
        assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'title' => 'Event Cancelled: Deletable Event',
        ]);
    }
});

// Test: Unauthorized user cannot update an event
test('non-admin cannot update an event', function () {
    $user = User::factory()->create(['role' => 'user']);
    $event = Event::factory()->create();

    actingAs($user);

    $response = put(route('admin.events.update', $event->id), [
        'event_name' => 'Unauthorized Update',
        'description' => 'Should not work',
        'date' => now()->toDateString(),
        'time' => '09:00:00',
        'location' => 'Nowhere',
    ]);

    $response->assertForbidden();
});

// Test: Unauthorized user cannot delete an event
test('non-admin cannot delete an event', function () {
    $user = User::factory()->create(['role' => 'user']);
    $event = Event::factory()->create();

    actingAs($user);

    $response = delete(route('admin.events.destroy', $event->id));

    $response->assertForbidden();
});


