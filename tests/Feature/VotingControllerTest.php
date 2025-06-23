<?php

use App\Models\User;
use App\Models\Voting;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, post, put, delete, patch, get};
use Carbon\Carbon;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    User::factory()->count(2)->create(); // users to notify
});

it('admin can store a voting and notify users', function () {
    actingAs($this->admin);

    $response = post(route('admin.votings.store'), [
        'title' => 'Test Voting',
        'description' => 'This is a test',
        'start_date' => '2025-06-01',
        'end_date' => '2025-06-02',
        'start_time' => '10:00',
        'end_time' => '15:00',
        'status' => 'active',
        'choices' => ['Choice A', 'Choice B'],
    ]);

    $response->assertRedirect(route('admin.votings.index'));
    $this->assertDatabaseHas('votings', ['title' => 'Test Voting']);
    $this->assertDatabaseCount('notifications', 3); // 1 admin + 2 users
});

it('admin can update a voting and replace choices', function () {
    actingAs($this->admin);

    $voting = Voting::factory()->create();

    $response = put(route('admin.votings.update', $voting->id), [
        'title' => 'Updated Voting',
        'description' => 'Updated desc',
        'start_date' => '2025-06-01',
        'end_date' => '2025-06-03',
        'start_time' => '09:00',
        'end_time' => '14:00',
        'status' => 'active',
        'choices' => ['New A', 'New B'],
    ]);

    $response->assertRedirect(route('admin.votings.index'));
    $this->assertDatabaseHas('votings', ['id' => $voting->id, 'title' => 'Updated Voting']);
    $this->assertDatabaseCount('choices', 2);
});

it('admin can delete a voting', function () {
    actingAs($this->admin);

    $voting = Voting::factory()->create();

    $response = delete(route('admin.votings.destroy', $voting->id));

    $response->assertRedirect(route('admin.votings.index'));
    $this->assertDatabaseMissing('votings', ['id' => $voting->id]);
});

it('admin can end a voting and notify users', function () {
    actingAs($this->admin);

    $voting = Voting::factory()->create(['status' => 'active']);
    $choice = $voting->choices()->create(['name' => 'Option A']);
    $voting->votes()->create([
        'choice_id' => $choice->id,
        'user_id' => User::factory()->create()->id,
    ]);

    $response = patch(route('admin.votings.end', $voting->id));
    $response->assertRedirect(route('admin.votings.index'));

    $voting->refresh();
    expect($voting->status)->toBe('inactive');
    expect(Notification::where('title', '🗳️ Voting Ended')->count())->toBe(4);
});

it('admin can view voting list and statuses auto-update', function () {
    $voting = Voting::factory()->create([
        'start_date' => now()->subDay()->toDateString(),
        'end_date' => now()->addDay()->toDateString(),
        'status' => 'inactive',
    ]);

    actingAs($this->admin);
    get(route('admin.votings.index'))->assertOk();

    $voting->refresh();
    expect($voting->status)->toBe('active');
});

it('admin can access voting create page', function () {
    actingAs($this->admin);
    get(route('admin.votings.create'))->assertOk();
});

it('admin can access voting edit page', function () {
    $voting = Voting::factory()->create();
    actingAs($this->admin);
    get(route('admin.votings.edit', $voting))->assertOk();
});

it('admin can view voting details and result percentages', function () {
    $voting = Voting::factory()->create();
    $choiceA = $voting->choices()->create(['name' => 'A']);
    $choiceB = $voting->choices()->create(['name' => 'B']);

    $user = User::factory()->create();
    $voting->votes()->create(['user_id' => $user->id, 'choice_id' => $choiceA->id]);

    actingAs($this->admin);
    get(route('admin.votings.show', $voting))
        ->assertOk()
        ->assertSee('A')
        ->assertSee('B');
});

// Validation Tests

it('store fails if required fields are missing', function () {
    actingAs($this->admin);
    post(route('admin.votings.store'), [])
        ->assertSessionHasErrors(['title', 'start_date', 'end_date', 'choices']);
});

it('update fails if end date is before start date', function () {
    $voting = Voting::factory()->create();
    actingAs($this->admin);

    put(route('admin.votings.update', $voting), [
        'title' => 'Test',
        'start_date' => '2025-06-10',
        'end_date' => '2025-06-01', // invalid
        'choices' => ['A'],
    ])->assertSessionHasErrors(['end_date']);
});
