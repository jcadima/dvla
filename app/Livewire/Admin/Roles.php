<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use Livewire\Component;

class Roles extends Component
{
    public $role_id = '';

    public $name;

    public $modalBtnLabel = '';

    public $modalTitle = '';

    public $modalBtnAction = '';

    public function render()
    {
        return view('livewire.admin.roles.index', [
            'roles' => Role::all(),
        ])->layout('layouts.admin', [
            //    'settings' => Setting::first(),
        ]);
    }

    public function create()
    {
        $this->dispatch('show-role-modal');
        $this->reset();
        $this->modalTitle = 'Create New Role';
        $this->modalBtnLabel = 'Save';
        $this->modalBtnAction = 'store()';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $role = new Role;
        $role->name = $this->name;
        $role->save();

        $this->name = '';

        $this->dispatch('notification', ['type' => 'success', 'message' => 'New Role created successfully']);
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $this->modalTitle = 'Edit Role';
        $this->modalBtnLabel = 'Save';
        $this->modalBtnAction = 'update()';
        $data = Role::find($id);
        $this->role_id = $data->id;
        $this->name = $data->name;
        $this->dispatch('show-role-modal');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $role = Role::find($this->role_id);
        $role->name = $this->name;
        $role->update();

        $this->dispatch('close-modal');
        $this->dispatch('notification', ['type' => 'success', 'message' => 'Role updated']);
    }

    public function cancel()
    {
        $this->role_id = '';
    }

    // Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->role_id = $id; // role  id
        $this->dispatch('show-delete-confirmation-modal');
    }

    public function destroy()
    {
        $role = Role::where('id', $this->role_id)->first();
        $role->delete();

        session()->flash('message', 'Role deleted');
        $this->dispatch('close-modal');
        $this->role_id = '';
    }

    public function clear()
    {
        $this->reset();
    }
}
