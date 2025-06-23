<?php

use App\Models\User;
use App\Models\Thread;
use Illuminate\Support\Facades\Notification;
use function Pest\Laravel\{actingAs, get, post, put, delete, assertDatabaseHas, assertDatabaseMissing};

beforeEach(function () {
    Notification::fake();

    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['role' => 'user']);
    $this->thread = Thread::factory()->create(['user_id' => $this->user->id]);
});

// Test: User can view threads index
it('user can view thread index page', function () {
    actingAs($this->user);
    get(route('threads.index'))->assertOk();
});

// Test: User can view individual thread
it('user can view thread details', function () {
    actingAs($this->user);
    get(route('threads.show', $this->thread))->assertOk();
});

// Test: User can create a thread
it('user can create a normal thread', function () {
    actingAs($this->user);

    $response = post(route('threads.store'), [
        'title' => 'New Thread',
        'description' => 'Just testing',
        'content' => 'This is a test thread',
        'type' => 'normal',
    ]);

    $response->assertRedirect(route('threads.index'));
    assertDatabaseHas('threads', ['title' => 'New Thread']);
});

// Test: Admin announcement triggers notifications
it('admin announcement sends notifications', function () {
    $otherUser = User::factory()->create(['role' => 'user']);
    actingAs($this->admin);

    post(route('threads.store'), [
        'title' => 'Important Notice',
        'description' => 'Announcement',
        'content' => 'This is important',
        'type' => 'announcement',
    ]);

    assertDatabaseHas('notifications', [
        'user_id' => $otherUser->id,
        'title' => 'New Announcement Posted',
    ]);
});


// Test: User can edit their own thread
it('user can access and update their own thread', function () {
    actingAs($this->user);

    get(route('threads.edit', $this->thread))->assertOk();

    put(route('threads.update', $this->thread), [
        'title' => 'Updated Title',
        'description' => 'Updated Desc',
        'content' => 'Updated Content',
        'type' => 'normal',
    ])->assertRedirect(route('threads.show', $this->thread));

    assertDatabaseHas('threads', ['id' => $this->thread->id, 'title' => 'Updated Title']);
});

// Test: User cannot edit another user's thread
it("user cannot edit another user's thread", function () {
    actingAs($this->user);
    $otherThread = Thread::factory()->create();

    get(route('threads.edit', $otherThread))->assertForbidden();
});

// Test: User can delete their own thread
it('user can delete their own thread', function () {
    actingAs($this->user);
    delete(route('threads.destroy', $this->thread))->assertRedirect(route('threads.index'));
    assertDatabaseMissing('threads', ['id' => $this->thread->id]);
});

// Test: Admin can delete a thread with reason
it('admin can delete a thread with reason and notify', function () {
    actingAs($this->admin);
    $userThread = Thread::factory()->create(['user_id' => $this->user->id]);

    delete(route('threads.destroyWithReason', $userThread), [
        'reason' => 'Spam',
    ])
        ->assertRedirect(route('threads.index'));

    assertDatabaseMissing('threads', ['id' => $userThread->id]);
    assertDatabaseHas('notifications', [
        'user_id' => $this->user->id,
        'title' => 'Thread Removed by Admin',
    ]);
});

// Test: Admin deletion with reason fails if reason missing
it('admin deletion with reason fails if reason is missing', function () {
    actingAs($this->admin);
    $thread = Thread::factory()->create(['user_id' => $this->user->id]);

    delete(route('threads.destroyWithReason', $thread), [])
        ->assertSessionHasErrors('reason');
});
