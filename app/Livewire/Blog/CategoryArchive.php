<?php

namespace App\Livewire\Blog;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class CategoryArchive extends Component
{
    use WithPagination;

    public $slug;
    public $category;

    public function mount($slug)
    {
        $this->category = Category::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.blog.category-archive', [
            'posts' => $this->category->posts()
                ->with(['user', 'tags'])
                ->published()
                ->latest('publish_at')
                ->paginate(config('blog.posts_per_page', 12))
        ])->layout('layouts.blog');
    }
}
