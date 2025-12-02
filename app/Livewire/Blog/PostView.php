<?php

namespace App\Livewire\Blog;

use Livewire\Component;
use App\Models\Post;

class PostView extends Component
{
    public $slug;
    public $post;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->post = Post::with([
            'category',
            'user',
            'tags',
            'comments' => function ($q) {
                $q->approved()->whereNull('parent_id')->with('replies');
            }
        ])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment view count
        $this->post->increment('views_count');
    }

    public function render()
    {
        return view('livewire.blog.post-view')
            ->layout('layouts.blog')
            ->title($this->post->meta_title ?? $this->post->title);
    }
}
