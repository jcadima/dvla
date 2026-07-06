<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contact;
use App\Models\Setting;

class Contacts extends Component
{
    use WithPagination;

    public $search = '';
    public $recipient = '';
    public $deleteId = null;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->recipient = Setting::first()?->recipient ?? '';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateRecipient()
    {
        Setting::first()?->update(['recipient' => $this->recipient]);
        session()->flash('success', 'Recipient email updated!');
    }

    public function confirmDelete(int $id)
    {
        $this->deleteId = $id;
        $this->dispatch('show-delete-confirmation-modal');
    }

    public function destroy()
    {
        if (!$this->deleteId) {
            return;
        }

        Contact::destroy($this->deleteId);
        $this->deleteId = null;

        session()->flash('success', 'Contact deleted!');
        $this->dispatch('close-modal');
    }

    public function clear()
    {
        $this->search = '';
    }

    public function render()
    {
        return view('livewire.admin.contacts.index', [
            'contacts' => $this->getContacts(),
        ])->layout('layouts.admin');
    }

    private function getContacts()
    {
        return Contact::query()
            ->when($this->search, fn($query) => $this->applySearch($query))
            ->orderByDesc('created_at')
            ->paginate(15);
    }

    private function applySearch($query)
    {
        return $query
            ->whereJsonContains('contact_data->name', $this->search)
            ->orWhereJsonContains('contact_data->email', $this->search)
            ->orWhereJsonContains('contact_data->message', $this->search);
    }
}
