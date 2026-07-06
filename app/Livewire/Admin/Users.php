<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    // protected $paginationTheme = 'bootstrap';

    public $user_id = null;

    public $role_id = null;

    public $user;

    public $name;

    public $email;

    public $password;

    public $password_confirmation_toggle = false;

    public $password_confirmation;

    public $modalBtnLabel = '';

    public $modalTitle = '';

    public $modalBtnAction = '';

    public $perPage = 10;

    public $search = '';

    public $sortField = 'created_at';

    public $sortAsc;

    public $filterRole = '';

    public function render()
    {
        $usersQuery = User::with('role');

        if ($this->filterRole) {
            $usersQuery->where('role_id', $this->filterRole);
        }

        return view('livewire.admin.users.index', [
            'roles' => Role::all(),
            'legacyCount' => User::whereNotNull('legacy_password')->count(),
            'users' => $usersQuery
                ->orderBy($this->sortField, 'desc')
                ->paginate($this->perPage),
        ])->layout('layouts.admin');
    }

    public function create()
    {
        // $this->dispatch('show-language-modal');
        $this->reset();
        $this->modalTitle = 'Create New User';
        $this->modalBtnLabel = 'Save';
        $this->modalBtnAction = 'store()';
        $this->password_confirmation_toggle = true;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = new User;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role_id = $this->role_id;
        $user->password = Hash::make($this->password);
        $user->save();

        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role_id = '';

        $this->dispatch('notification', ['type' => 'success', 'message' => 'New User created successfully']);
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $this->password_confirmation_toggle = false;
        $this->modalTitle = 'Edit User';
        $this->modalBtnLabel = 'Save';
        $this->modalBtnAction = 'update()';
        $data = User::with('role')->find($id);
        $this->user_id = $data->id;
        $this->name = $data->name;
        $this->role_id = $data->role->id;
        $this->email = $data->email;
        $this->dispatch('show-user-modal');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'unique:users,email,'.$this->user_id,
            'password' => 'sometimes',
        ]);

        $user = User::find($this->user_id);
        if ($this->email != $user->email) {
            $user->email = $this->email;
        }

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        if ($this->role_id) {
            $user->role_id = $this->role_id;
        }

        $user->name = $this->name;
        $user->update();

        $this->dispatch('close-modal');
        $this->dispatch('notification', ['type' => 'success', 'message' => 'User Data updated']);
    }

    public function cancel()
    {
        $this->user_id = '';
    }

    // Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->user_id = $id; // user  id
        $this->dispatch('show-delete-confirmation-modal');
    }

    public function destroy()
    {
        $user = User::where('id', $this->user_id)->first();
        $user->delete();

        session()->flash('message', 'User has been deleted');
        $this->dispatch('close-modal');
        $this->user_id = '';
    }

    public function clear()
    {
        $this->reset();
    }
}
