<?php

use App\Models\User;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, patch, get, post, assertDatabaseHas};

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->notification = Notification::factory()->create([
        'user_id' => $this->user->id,
        'title' => 'Test Notification',
        'message' => 'This is a test notification.',
        'read' => false
    ]);
});

// NT-UT01
test('user can view all notifications', function () {
    actingAs($this->user)
        ->get(route('notifications.index'))
        ->assertOk()
        ->assertSee('Test Notification');
});

// NT-UT02
test('user can filter unread notifications', function () {
    actingAs($this->user)
        ->get(route('notifications.index', ['filter' => 'unread']))
        ->assertOk()
        ->assertSee('Test Notification');
});

// NT-UT03
test('user can filter read notifications', function () {
    $this->notification->update(['read' => true]);
    actingAs($this->user)
        ->get(route('notifications.index', ['filter' => 'read']))
        ->assertOk()
        ->assertSee('Test Notification');
});

// NT-UT04
test('user can mark a single notification as read', function () {
    $user = User::factory()->create();
    $notification = Notification::factory()->create([
        'user_id' => $user->id,
        'read' => false,
    ]);

    actingAs($user);
    patch(route('notifications.read', $notification))->assertRedirect();

$this->assertDatabaseHas('notifications', [
    'id' => $notification->id,
    'read' => true,
]);
});



// NT-UT05
test('user cannot mark another user\'s notification as read', function () {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();

    $notification = Notification::factory()->create([
        'user_id' => $owner->id,
        'read' => false,
    ]);

    actingAs($otherUser);
    patch(route('notifications.read', $notification))->assertForbidden();
});


// NT-UT06
test('user can mark all notifications as read', function () {
    $user = User::factory()->create();

    Notification::factory()->count(3)->create([
        'user_id' => $user->id,
        'read' => false,
    ]);

    actingAs($user);
    patch(route('notifications.markAll'))->assertRedirect();

    $this->assertDatabaseMissing('notifications', ['user_id' => $user->id, 'read' => false]);
});

