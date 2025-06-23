<?php
use App\Models\User;
use App\Models\Voting;
use App\Models\Choice;
use function Pest\Laravel\{actingAs, get, post, put, delete, assertDatabaseHas, assertDatabaseMissing};

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->voting = Voting::factory()->create();
    actingAs($this->admin);
});

// Admin can access the create choice form
test('admin can access the create choice form', function () {
    get(route('admin.votings.choices.create', $this->voting))->assertOk();
});

// Admin can store a new choice
test('admin can store a valid choice', function () {
    post(route('admin.votings.choices.store', $this->voting), [
        'name' => 'Option A',
    ])->assertRedirect(route('admin.votings.show', $this->voting));

    assertDatabaseHas('choices', [
        'voting_id' => $this->voting->id,
        'name' => 'Option A',
    ]);
});

// Validation fails when name is missing
test('store fails if name is missing', function () {
    post(route('admin.votings.choices.store', $this->voting), [])
        ->assertSessionHasErrors(['name']);
});

// Admin can access the edit form for a choice
test('admin can access edit form for a choice', function () {
    $choice = Choice::factory()->create(['voting_id' => $this->voting->id]);
    get(route('admin.votings.choices.edit', [$this->voting, $choice]))->assertOk();
});

// Admin can update a choice
test('admin can update a choice name', function () {
    $choice = Choice::factory()->create(['voting_id' => $this->voting->id]);
    put(route('admin.votings.choices.update', [$this->voting, $choice]), [
        'name' => 'Updated Option',
    ])->assertRedirect(route('admin.votings.show', $this->voting));

    assertDatabaseHas('choices', [
        'id' => $choice->id,
        'name' => 'Updated Option',
    ]);
});

// Validation fails when updating with empty name
test('update fails if name is empty', function () {
    $choice = Choice::factory()->create(['voting_id' => $this->voting->id]);
    put(route('admin.votings.choices.update', [$this->voting, $choice]), [])
        ->assertSessionHasErrors(['name']);
});

// Admin can delete a choice
test('admin can delete a choice', function () {
    $choice = Choice::factory()->create(['voting_id' => $this->voting->id]);
    delete(route('admin.votings.choices.update', [$this->voting, $choice]))
        ->assertRedirect(route('admin.votings.show', $this->voting));

    assertDatabaseMissing('choices', ['id' => $choice->id]);
});