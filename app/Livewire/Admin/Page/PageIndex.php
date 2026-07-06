<?php

namespace App\Livewire\Admin\Page;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Page;

class PageIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $selectedDomainId;
    public $perPage = 10;
    public $search = '';
    public $page_id;
    public $sortAsc;
    public $sortField = 'id';


    public function render()
    {
        $pagesQuery = Page::filterBySearch($this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

        $pages = tap($pagesQuery->paginate($this->perPage), function ($paginatedQuery) {
        });

        return view('livewire.admin.pages.index', [
            'pages' => $pages,
            'showStatus' => true,
        ])->layout('layouts.admin');
    }

    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->page_id = $id; //user  id
        $this->dispatch('show-delete-confirmation-modal');
    }


    public function destroy()
    {
        Page::find($this->page_id)->delete();

        $this->dispatch('notification', [
            'type' => 'success',
            'message' => "Page deleted Successfully",
        ]);

        $this->page_id = '';
        $this->dispatch('close-modal');
    }

    public function cancel()
    {
        $this->page_id = '';
        $this->dispatch('close-modal');
    }
}
