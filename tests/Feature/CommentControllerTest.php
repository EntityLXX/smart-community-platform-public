<?php
use App\Models\User;
use App\Models\Thread;
use App\Models\Comment;
use App\Models\Notification;
use function Pest\Laravel\{actingAs, post, get, put, delete, assertDatabaseHas, assertDatabaseMissing};

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->thread = Thread::factory()->create();
    actingAs($this->user);
});

test('user can post a new comment', function () {
    post(route('comments.store', $this->thread), [
        'content' => 'This is a test comment',
    ])->assertRedirect(route('threads.show', $this->thread));

    assertDatabaseHas('comments', [
        'thread_id' => $this->thread->id,
        'content' => 'This is a test comment',
    ]);
});

test('user can reply to a comment', function () {
    $parent = Comment::factory()->create(['thread_id' => $this->thread->id]);
    post(route('comments.store', $this->thread), [
        'content' => 'This is a reply',
        'parent_id' => $parent->id,
    ])->assertRedirect(route('threads.show', $this->thread));

    assertDatabaseHas('comments', [
        'parent_id' => $parent->id,
        'content' => 'This is a reply',
    ]);
});

test('comment store fails if content is missing', function () {
    post(route('comments.store', $this->thread), [])
        ->assertSessionHasErrors('content');
});

test('user cannot access edit form of another user\'s comment', function () {
    $otherComment = Comment::factory()->create(['user_id' => $this->admin->id]);
    get(route('comments.edit', $otherComment))->assertForbidden();
});

test('user can update their own comment', function () {
    $comment = Comment::factory()->create(['user_id' => $this->user->id]);
    put(route('comments.update', $comment), [
        'content' => 'Updated content',
    ])->assertRedirect(route('threads.show', $comment->thread));

    assertDatabaseHas('comments', [
        'id' => $comment->id,
        'content' => 'Updated content',
    ]);
});

test('user cannot update another user\'s comment', function () {
    $comment = Comment::factory()->create(['user_id' => $this->admin->id]);
    put(route('comments.update', $comment), [
        'content' => 'Attempted update',
    ])->assertForbidden();
});

test('user can delete their own comment', function () {
    $comment = Comment::factory()->create(['user_id' => $this->user->id]);
    delete(route('comments.destroy', $comment))->assertRedirect();
    assertDatabaseMissing('comments', ['id' => $comment->id]);
});

test('user cannot delete another user\'s comment', function () {
    $comment = Comment::factory()->create(['user_id' => $this->admin->id]);
    delete(route('comments.destroy', $comment))->assertForbidden();
    assertDatabaseHas('comments', ['id' => $comment->id]);
});

test('admin can delete a comment with reason and notify', function () {
    $comment = Comment::factory()->create(['user_id' => $this->user->id]);
    actingAs($this->admin);
    delete(route('comments.destroyWithReason', $comment), [
        'reason' => 'Inappropriate content'
    ])->assertRedirect();


    assertDatabaseMissing('comments', ['id' => $comment->id]);
    assertDatabaseHas('notifications', [
        'user_id' => $this->user->id,
        'title' => 'Comment Removed by Admin',
    ]);
});

test('admin deletion with reason fails if reason is missing', function () {
    $comment = Comment::factory()->create(['user_id' => $this->user->id]);
    actingAs($this->admin);
    delete(route('comments.destroyWithReason', $comment), [])
        ->assertSessionHasErrors('reason');
});