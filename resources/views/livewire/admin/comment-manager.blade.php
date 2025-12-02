<div>
    <div class="container-fluid py-4">
        <h2 class="mb-4">Comment Moderation</h2>

        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-6">
                <input type="text" wire:model.live="search" class="form-control" placeholder="Search comments...">
            </div>
            <div class="col-md-6">
                <select wire:model.live="filterStatus" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="spam">Spam</option>
                </select>
            </div>
        </div>

        <!-- Comments Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Author</th>
                                <th>Post</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($comments as $comment)
                                <tr>
                                    <td>{{ $comment->user->name ?? $comment->author_name }}</td>
                                    <td>
                                        <a href="{{ route('blog.show', $comment->post->slug) }}" target="_blank">
                                            {{ Str::limit($comment->post->title, 30) }}
                                        </a>
                                    </td>
                                    <td>{{ Str::limit($comment->content, 50) }}</td>
                                    <td>
                                        @if($comment->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($comment->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Spam</span>
                                        @endif
                                    </td>
                                    <td>{{ $comment->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if($comment->status !== 'approved')
                                            <button wire:click="approve({{ $comment->id }})" class="btn btn-sm btn-success">
                                                <i class="bi bi-check"></i>
                                            </button>
                                        @endif
                                        @if($comment->status !== 'spam')
                                            <button wire:click="reject({{ $comment->id }})" class="btn btn-sm btn-warning">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        @endif
                                        <button wire:click="delete({{ $comment->id }})"
                                            onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No comments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>