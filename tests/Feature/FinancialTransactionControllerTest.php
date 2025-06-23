<?php

use App\Models\User;
use App\Models\FinancialTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, post, put, delete, get, assertDatabaseHas, assertDatabaseMissing};

uses(RefreshDatabase::class);

// Setup users
beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin', 'can_manage_facility' => true]);
    $this->unauthorizedAdmin = User::factory()->create(['role' => 'admin', 'can_manage_facility' => false]);
});

// Index view
test('authorized admin can access finance index page', function () {
    actingAs($this->admin);
    get(route('admin.finance.index'))->assertOk();
});

// Create view
test('authorized admin can access create page for income', function () {
    actingAs($this->admin);
    get(route('admin.finance.create', 'income'))->assertOk();
});

test('authorized admin can access create page for expense', function () {
    actingAs($this->admin);
    get(route('admin.finance.create', 'expense'))->assertOk();
});

test('unauthorized admin cannot access create page', function () {
    actingAs($this->unauthorizedAdmin);
    get(route('admin.finance.create', 'income'))
        ->assertRedirect(route('admin.finance.index'))
        ->assertSessionHas('error');
});

test('create page returns 404 on invalid type', function () {
    actingAs($this->admin);
    get(route('admin.finance.create', 'invalid'))->assertNotFound();
});

// Store
test('admin can store income transaction', function () {
    actingAs($this->admin);
    post(route('admin.finance.store'), [
        'type' => 'income',
        'category' => 'Donation',
        'description' => 'Friday Donation',
        'amount' => 150.00,
        'date' => now()->toDateString(),
    ])->assertRedirect(route('admin.finance.index'));

    assertDatabaseHas('financial_transactions', ['type' => 'income', 'category' => 'Donation']);
});

test('admin can store expense transaction', function () {
    actingAs($this->admin);
    post(route('admin.finance.store'), [
        'type' => 'expense',
        'category' => 'Maintenance',
        'description' => 'Repair',
        'amount' => 80.00,
        'date' => now()->toDateString(),
    ])->assertRedirect(route('admin.finance.index'));

    assertDatabaseHas('financial_transactions', ['type' => 'expense', 'category' => 'Maintenance']);
});

test('store fails with validation error', function () {
    actingAs($this->admin);
    post(route('admin.finance.store'), ['type' => 'income'])
        ->assertSessionHasErrors(['category', 'description', 'amount', 'date']);
});

// Update
test('admin can update transaction', function () {
    actingAs($this->admin);
    $tx = FinancialTransaction::factory()->create();

    put(route('admin.finance.update', $tx->id), [
        'type' => $tx->type,
        'category' => 'Updated Category',
        'description' => 'Updated Description',
        'amount' => 99.99,
        'date' => now()->toDateString(),
    ])->assertRedirect(route('admin.finance.history'));

    assertDatabaseHas('financial_transactions', ['id' => $tx->id, 'category' => 'Updated Category']);
});

// Destroy
test('authorized admin can delete transaction', function () {
    actingAs($this->admin);
    $tx = FinancialTransaction::factory()->create();

    delete(route('admin.finance.destroy', $tx->id))->assertRedirect(route('admin.finance.history'));
    assertDatabaseMissing('financial_transactions', ['id' => $tx->id]);
});

test('unauthorized admin cannot delete transaction', function () {
    actingAs($this->unauthorizedAdmin);
    $tx = FinancialTransaction::factory()->create();

    delete(route('admin.finance.destroy', $tx->id))
        ->assertRedirect(route('admin.finance.history'))
        ->assertSessionHas('error');

    assertDatabaseHas('financial_transactions', ['id' => $tx->id]);
});

// Summary and Export
test('admin can view category summary', function () {
    FinancialTransaction::factory()->count(2)->create(['category' => 'Test']);
    actingAs($this->admin);
    get(route('admin.finance.chart.category-summary'))->assertOk()->assertJsonFragment(['category' => 'Test']);
});

test('authorized admin can export data', function () {
    actingAs($this->admin);
    get(route('admin.finance.export'))->assertOk()->assertHeader(
        'Content-Type',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );
});

test('unauthorized admin cannot export data', function () {
    actingAs($this->unauthorizedAdmin);
    get(route('admin.finance.export'))
        ->assertRedirect(route('admin.finance.history'))
        ->assertSessionHas('error');
});
