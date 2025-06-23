<?php
use App\Models\User;
use function Pest\Laravel\{actingAs, get, put, patch, delete, assertDatabaseHas, assertDatabaseMissing};

beforeEach(function () {
    $this->superAdmin = User::factory()->create(['id' => 1, 'role' => 'admin']);
    $this->admin = User::factory()->create(['role' => 'admin']); // now not ID 1
    $this->user = User::factory()->create(['role' => 'user']);
    actingAs($this->superAdmin);
});

// Test: Admin can view the user list
test('admin can view user list', function () {
    get(route('admin.users.index'))->assertOk();
});

// Test: Admin can filter users by role
test('admin can filter users by role', function () {
    get(route('admin.users.index', ['role' => 'admin']))
        ->assertOk()
        ->assertSee($this->admin->name);
});

// Test: Admin can search users by keyword
test('admin can search for a user by name or email', function () {
    get(route('admin.users.index', ['search' => $this->user->name]))
        ->assertOk()
        ->assertSee($this->user->email);
});

// Test: Admin can access edit form for a user
test('admin can access edit form for another user', function () {
    get(route('admin.users.edit', $this->user))->assertOk();
});

// Test: Admin cannot access edit form for another admin
test('admin cannot edit another admin', function () {
    actingAs($this->admin);
    get(route('admin.users.edit', $this->superAdmin))
        ->assertSessionHas('error');
});

// Test: Admin can update a user
test('admin can update a user role and facility permission', function () {
    $response = patch(route('admin.users.update', $this->user), [
        'role' => 'admin',
        'can_manage_facility' => true,
    ]);
    $response->assertRedirect(route('admin.users.index'));

    assertDatabaseHas('users', [
        'id' => $this->user->id,
        'role' => 'admin',
        'can_manage_facility' => true,
    ]);
});

// Test: Admin cannot update self
test('admin cannot update themselves', function () {
    actingAs($this->admin);
    patch(route('admin.users.update', $this->admin), [
        'role' => 'user',
    ])->assertSessionHas('error');
});

// Test: Super Admin can toggle another user role
test('super admin can toggle another user role', function () {
    patch(route('admin.users.toggleRole', $this->user))
        ->assertSessionHas('success');

    $this->user->refresh();
    expect($this->user->role)->toBe('admin');
});

// Test: Cannot toggle own role
test('user cannot toggle their own role', function () {
    patch(route('admin.users.toggleRole', $this->superAdmin))
        ->assertSessionHas('error');
});

// Test: Admin can toggle facility access for another admin
test('admin can toggle facility access for an admin', function () {
    $admin = User::factory()->create(['role' => 'admin', 'can_manage_facility' => false]);

    patch(route('admin.users.toggleFacilityAccess', $admin))
        ->assertSessionHas('success');

    $admin->refresh();
    expect($admin->can_manage_facility)->toBeTrue();
});

// Test: Cannot toggle facility access for non-admin
test('cannot toggle facility access for non-admin user', function () {
    patch(route('admin.users.toggleFacilityAccess', $this->user))
        ->assertSessionHas('error');
});

// Test: Cannot delete Super Admin or another admin
test('admin cannot delete super admin or admin', function () {
    delete(route('admin.users.destroy', $this->superAdmin))
        ->assertSessionHas('error');
    delete(route('admin.users.destroy', $this->admin))
        ->assertSessionHas('error');
});

// Test: Admin can delete a normal user
test('admin can delete a user', function () {
    $user = User::factory()->create(['role' => 'user']);

    delete(route('admin.users.destroy', $user))
        ->assertSessionHas('success');

    assertDatabaseMissing('users', ['id' => $user->id]);
});