<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Media;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'scheduled_posts' => Post::where('status', 'scheduled')->count(),
            'total_categories' => Category::count(),
            'total_tags' => Tag::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'approved_comments' => Comment::where('status', 'approved')->count(),
            'total_media' => Media::count(),
            'total_views' => Post::sum('views_count'),
        ];

        $recent_posts = Post::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $recent_comments = Comment::with(['post', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recent_posts' => $recent_posts,
            'recent_comments' => $recent_comments,
        ])->layout('layouts.admin');
    }
}
