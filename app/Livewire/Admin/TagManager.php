<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tag;

class TagManager extends Component
{
    use WithPagination;

    public $name, $tagId;
    public $isEditing = false;
    public $showModal = false;
    public $search = '';

    protected $rules = [
        'name' => 'required|min:2|max:255',
    ];

    public function resetForm()
    {
        $this->reset(['name', 'tagId', 'isEditing', 'showModal']);
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
        Tag::create(['name' => $this->name]);
        session()->flash('message', 'Tag created successfully.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $this->tagId = $tag->id;
        $this->name = $tag->name;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();
        Tag::findOrFail($this->tagId)->update(['name' => $this->name]);
        session()->flash('message', 'Tag updated successfully.');
        $this->resetForm();
    }

    public function delete($id)
    {
        Tag::findOrFail($id)->delete();
        session()->flash('message', 'Tag deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.tag-manager', [
            'tags' => Tag::where('name', 'like', '%' . $this->search . '%')
                ->withCount('posts')
                ->latest()
                ->paginate(10)
        ])->layout('layouts.admin');
    }
}
