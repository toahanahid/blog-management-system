<?php

namespace App\Livewire\Blog;

use Livewire\Component;
use App\Models\Comment;

class CommentSection extends Component
{
    public $postId;
    public $content;
    public $parentId = null;
    public $author_name;
    public $author_email;

    protected $rules = [
        'content' => 'required|min:3',
        'author_name' => 'required_unless:auth,true',
        'author_email' => 'required_unless:auth,true|email',
    ];

    public function mount($postId)
    {
        $this->postId = $postId;
    }

    public function submitComment()
    {
        $this->validate();

        Comment::create([
            'post_id' => $this->postId,
            'parent_id' => $this->parentId,
            'user_id' => auth()->id(),
            'author_name' => auth()->check() ? auth()->user()->name : $this->author_name,
            'author_email' => auth()->check() ? auth()->user()->email : $this->author_email,
            'content' => $this->content,
            'status' => config('blog.comment_moderation') ? 'pending' : 'approved',
        ]);

        $this->reset(['content', 'parentId']);
        session()->flash('comment_message', 'Comment submitted successfully. It will appear after moderation.');
    }

    public function reply($commentId)
    {
        $this->parentId = $commentId;
    }

    public function cancelReply()
    {
        $this->parentId = null;
    }

    public function render()
    {
        return view('livewire.blog.comment-section', [
            'comments' => Comment::where('post_id', $this->postId)
                ->whereNull('parent_id')
                ->approved()
                ->with([
                    'replies' => function ($q) {
                        $q->approved();
                    }
                ])
                ->latest()
                ->get()
        ]);
    }
}
