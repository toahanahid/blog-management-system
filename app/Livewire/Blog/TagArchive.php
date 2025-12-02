<?php

namespace App\Livewire\Blog;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tag;

class TagArchive extends Component
{
    use WithPagination;

    public $slug;
    public $tag;

    public function mount($slug)
    {
        $this->tag = Tag::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.blog.tag-archive', [
            'posts' => $this->tag->posts()
                ->with(['category', 'user'])
                ->published()
                ->latest('publish_at')
                ->paginate(config('blog.posts_per_page', 12))
        ])->layout('layouts.blog');
    }
}
