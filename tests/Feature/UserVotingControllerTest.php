<?php
use App\Models\User;
use App\Models\Voting;
use App\Models\Choice;
use App\Models\Vote;
use Illuminate\Support\Carbon;
use function Pest\Laravel\{actingAs, get, post, assertDatabaseHas};

beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'user']);
    actingAs($this->user);
});

// User can view voting list
test('user can view voting list', function () {
    Voting::factory()->count(2)->create();
    get(route('user.votings.index'))->assertOk()->assertSee('Voting');
});

// User can access the details of a voting session
test('user can view voting detail page', function () {
    $voting = Voting::factory()->create();
    get(route('user.votings.show', $voting->id))->assertOk()->assertSee($voting->title);
});

// User can submit a vote for an active voting session
test('user can submit a vote', function () {
    $voting = Voting::factory()->create(['status' => 'active']);
    $choice = Choice::factory()->create(['voting_id' => $voting->id]);

    post(route('user.votings.vote', $voting->id), [
        'choice_id' => $choice->id
    ])->assertRedirect(route('user.votings.index'));

    assertDatabaseHas('votes', [
        'voting_id' => $voting->id,
        'user_id' => $this->user->id,
        'choice_id' => $choice->id,
    ]);
});

// User can update an existing vote
test('user can update an existing vote', function () {
    $voting = Voting::factory()->create(['status' => 'active']);
    $choice1 = Choice::factory()->create(['voting_id' => $voting->id]);
    $choice2 = Choice::factory()->create(['voting_id' => $voting->id]);

    Vote::create([
        'voting_id' => $voting->id,
        'user_id' => $this->user->id,
        'choice_id' => $choice1->id,
    ]);

    post(route('user.votings.vote', $voting->id), [
        'choice_id' => $choice2->id
    ])->assertRedirect(route('user.votings.index'));

    assertDatabaseHas('votes', [
        'voting_id' => $voting->id,
        'user_id' => $this->user->id,
        'choice_id' => $choice2->id,
    ]);
});

// Voting fails if choice_id is missing or invalid
test('vote submission fails if choice_id is invalid', function () {
    $voting = Voting::factory()->create(['status' => 'active']);
    post(route('user.votings.vote', $voting->id), [])
        ->assertSessionHasErrors('choice_id');
});

// Voting cannot be submitted if session is inactive or expired
test('vote cannot be submitted for inactive voting', function () {
    $voting = Voting::factory()->create([
        'status' => 'inactive',
        'start_date' => now()->subDays(3)->toDateString(),
        'end_date' => now()->subDays(1)->toDateString()
    ]);

    $choice = Choice::factory()->create(['voting_id' => $voting->id]);

    post(route('user.votings.vote', $voting->id), [
        'choice_id' => $choice->id
    ])->assertRedirect(route('user.votings.index'));
});