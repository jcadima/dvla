<?php

use App\Livewire\Admin\Users;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function () {
    $this->adminRole = Role::create(['name' => 'Admin']);
    $this->userRole = Role::create(['name' => 'User']);

    $this->adminUser = User::factory()->create([
        'role_id' => $this->adminRole->id,
    ]);
});

describe('User Creation', function () {
    it('can create a new user with valid data', function () {
        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('role_id', $this->userRole->id)
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('store');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role_id' => $this->userRole->id,
        ]);
    });

    it('requires a name to create user', function () {
        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->set('name', '')
            ->set('email', 'john@example.com')
            ->set('role_id', $this->userRole->id)
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('store')
            ->assertHasErrors(['name' => 'required']);
    });

    it('requires a valid email to create user', function () {
        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->set('name', 'John Doe')
            ->set('email', 'invalid-email')
            ->set('role_id', $this->userRole->id)
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('store')
            ->assertHasErrors(['email' => 'email']);
    });

    it('requires a unique email to create user', function () {
        User::factory()->create(['email' => 'existing@example.com', 'role_id' => $this->userRole->id]);

        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->set('name', 'John Doe')
            ->set('email', 'existing@example.com')
            ->set('role_id', $this->userRole->id)
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('store')
            ->assertHasErrors(['email' => 'unique']);
    });

    it('requires a role to create user', function () {
        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('role_id', '')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('store')
            ->assertHasErrors(['role_id' => 'required']);
    });

    it('requires password confirmation to match', function () {
        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('role_id', $this->userRole->id)
            ->set('password', 'password123')
            ->set('password_confirmation', 'differentpassword')
            ->call('store')
            ->assertHasErrors(['password' => 'confirmed']);
    });

    it('requires password minimum length', function () {
        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('role_id', $this->userRole->id)
            ->set('password', 'abc')
            ->set('password_confirmation', 'abc')
            ->call('store')
            ->assertHasErrors(['password' => 'min']);
    });

    it('hashes the password when creating user', function () {
        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('role_id', $this->userRole->id)
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('store');

        $user = User::where('email', 'john@example.com')->first();
        expect($user->password)->not->toBe('password123');
        expect(Hash::check('password123', $user->password))->toBeTrue();
    });

    it('dispatches success notification after creating user', function () {
        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('role_id', $this->userRole->id)
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('store')
            ->assertDispatched('notification');
    });
});

describe('User Editing', function () {
    it('can load user data for editing', function () {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role_id' => $this->userRole->id,
        ]);

        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->call('edit', $user->id)
            ->assertSet('user_id', $user->id)
            ->assertSet('name', 'Jane Doe')
            ->assertSet('email', 'jane@example.com')
            ->assertSet('role_id', $this->userRole->id);
    });

    it('can update user name', function () {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role_id' => $this->userRole->id,
        ]);

        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->call('edit', $user->id)
            ->set('name', 'Jane Smith')
            ->call('update');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Smith',
        ]);
    });

    it('can update user email', function () {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role_id' => $this->userRole->id,
        ]);

        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->call('edit', $user->id)
            ->set('email', 'janesmith@example.com')
            ->call('update');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'janesmith@example.com',
        ]);
    });

    it('can update user role', function () {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role_id' => $this->userRole->id,
        ]);

        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->call('edit', $user->id)
            ->set('role_id', $this->adminRole->id)
            ->call('update');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role_id' => $this->adminRole->id,
        ]);
    });

    it('can update user password', function () {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role_id' => $this->userRole->id,
        ]);

        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->call('edit', $user->id)
            ->set('password', 'newpassword123')
            ->call('update');

        $user->refresh();
        expect(Hash::check('newpassword123', $user->password))->toBeTrue();
    });

    it('keeps current password when password field is empty on update', function () {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role_id' => $this->userRole->id,
            'password' => Hash::make('originalpassword'),
        ]);

        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->call('edit', $user->id)
            ->set('name', 'Jane Smith')
            ->set('password', '')
            ->call('update');

        $user->refresh();
        expect(Hash::check('originalpassword', $user->password))->toBeTrue();
    });

    it('validates unique email on update excluding current user', function () {
        $otherUser = User::factory()->create([
            'email' => 'other@example.com',
            'role_id' => $this->userRole->id,
        ]);

        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role_id' => $this->userRole->id,
        ]);

        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->call('edit', $user->id)
            ->set('email', 'other@example.com')
            ->call('update')
            ->assertHasErrors(['email' => 'unique']);
    });

    it('allows keeping same email on update', function () {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role_id' => $this->userRole->id,
        ]);

        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->call('edit', $user->id)
            ->set('name', 'Jane Smith')
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ]);
    });

    it('dispatches close-modal event after update', function () {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'role_id' => $this->userRole->id,
        ]);

        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->call('edit', $user->id)
            ->set('name', 'Jane Smith')
            ->call('update')
            ->assertDispatched('close-modal');
    });
});

describe('User Deletion', function () {
    it('can delete a user', function () {
        $user = User::factory()->create([
            'name' => 'To Delete',
            'email' => 'delete@example.com',
            'role_id' => $this->userRole->id,
        ]);

        Livewire::actingAs($this->adminUser)
            ->test(Users::class)
            ->call('deleteConfirmation', $user->id)
            ->call('destroy');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    });
});
