<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Category;

class Home extends Component
{
    public function render()
    {
        $featuredPosts = Post::with(['category', 'user', 'tags'])
            ->published()
            ->latest('publish_at')
            ->take(5)
            ->get();

        $latestPosts = Post::with(['category', 'user'])
            ->published()
            ->latest('publish_at')
            ->skip(5)
            ->take(6)
            ->get();

        $categories = Category::whereHas('posts')
            ->withCount('posts')
            ->get();

        return view('livewire.home', [
            'featuredPosts' => $featuredPosts,
            'latestPosts' => $latestPosts,
            'categories' => $categories,
        ])->layout('layouts.blog');
    }
}
