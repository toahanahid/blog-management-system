<?php

namespace App\Livewire\Blog;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class BlogList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    public $selectedTag = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Post::with(['category', 'user', 'tags'])
            ->published()
            ->latest('publish_at');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->selectedTag) {
            $query->whereHas('tags', function ($q) {
                $q->where('tags.id', $this->selectedTag);
            });
        }

        return view('livewire.blog.blog-list', [
            'posts' => $query->paginate(config('blog.posts_per_page', 12)),
            'categories' => Category::withCount('posts')->get(),
            'tags' => Tag::withCount('posts')->get(),
        ])->layout('layouts.blog');
    }
}
