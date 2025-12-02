<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Comment;

class CommentManager extends Component
{
    use WithPagination;

    public $filterStatus = '';
    public $search = '';

    public function approve($id)
    {
        Comment::findOrFail($id)->update(['status' => 'approved']);
        session()->flash('message', 'Comment approved successfully.');
    }

    public function reject($id)
    {
        Comment::findOrFail($id)->update(['status' => 'spam']);
        session()->flash('message', 'Comment marked as spam.');
    }

    public function delete($id)
    {
        Comment::findOrFail($id)->delete();
        session()->flash('message', 'Comment deleted successfully.');
    }

    public function render()
    {
        $query = Comment::with(['post', 'user']);

        if ($this->search) {
            $query->where('content', 'like', '%' . $this->search . '%');
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.admin.comment-manager', [
            'comments' => $query->latest()->paginate(15)
        ])->layout('layouts.admin');
    }
}
