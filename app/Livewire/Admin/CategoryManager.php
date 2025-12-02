<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class CategoryManager extends Component
{
    use \Livewire\WithPagination;

    public $name, $description, $categoryId;
    public $isEditing = false;
    public $showModal = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'description' => 'nullable|max:500',
    ];

    public function resetForm()
    {
        $this->reset(['name', 'description', 'categoryId', 'isEditing', 'showModal']);
        $this->resetValidation();
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        \App\Models\Category::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Category created successfully.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $category = \App\Models\Category::findOrFail($this->categoryId);
        $category->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Category updated successfully.');
        $this->resetForm();
    }

    public function delete($id)
    {
        \App\Models\Category::findOrFail($id)->delete();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.category-manager', [
            'categories' => \App\Models\Category::where('name', 'like', '%' . $this->search . '%')
                ->withCount('posts')
                ->latest()
                ->paginate(10)
        ])->layout('layouts.admin');
    }
}
