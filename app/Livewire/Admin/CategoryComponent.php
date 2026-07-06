<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CategoryComponent extends Component
{
    use WithPagination;

    public $category_id, $name, $slug, $status = true;
    public $modalTitle = 'Add Category';
    public $modalBtnAction = 'store';
    public $modalBtnLabel = 'Create Category';
    public $search = '';

    protected $rules = [
        'name' => 'required|min:3|max:255|unique:categories,name',
        'slug' => 'required|unique:categories,slug',
        'status' => 'boolean'
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        $categories = Category::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.category-component', [
            'categories' => $categories
        ])->layout('layouts.admin');
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function create()
    {
        $this->resetForm();
        $this->modalTitle = 'Add Category';
        $this->modalBtnAction = 'store';
        $this->modalBtnLabel = 'Create Category';
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->status = $category->status;
        
        $this->modalTitle = 'Edit Category';
        $this->modalBtnAction = 'update';
        $this->modalBtnLabel = 'Update Category';
    }

    public function store()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status
        ]);

        session()->flash('message', 'Category created successfully.');
        $this->dispatch('close-modal');
        $this->resetForm();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3|max:255|unique:categories,name,' . $this->category_id,
            'slug' => 'required|unique:categories,slug,' . $this->category_id,
            'status' => 'boolean'
        ]);

        $category = Category::findOrFail($this->category_id);
        $category->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status
        ]);

        session()->flash('message', 'Category updated successfully.');
        $this->dispatch('close-modal');
        $this->resetForm();
    }

    public function deleteConfirmation($id)
    {
        $this->category_id = $id;
    }

    public function destroy()
    {
        $category = Category::findOrFail($this->category_id);
        
        // Check if category has posts
        if ($category->posts()->count() > 0) {
            session()->flash('error', 'Cannot delete category. It has associated posts.');
            return;
        }

        $category->delete();
        session()->flash('message', 'Category deleted successfully.');
        $this->dispatch('close-modal');
        $this->resetForm();
    }

    public function cancel()
    {
        $this->resetForm();
    }

    public function clear()
    {
        $this->search = '';
    }

    private function resetForm()
    {
        $this->category_id = null;
        $this->name = '';
        $this->slug = '';
        $this->status = true;
    }
}
