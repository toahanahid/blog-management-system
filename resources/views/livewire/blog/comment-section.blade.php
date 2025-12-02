<div>
    @if (session()->has('comment_message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('comment_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Comment Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $parentId ? 'Reply to Comment' : 'Leave a Comment' }}</h5>

            @if($parentId)
                <p class="text-muted">Replying to comment #{{ $parentId }}
                    <button wire:click="cancelReply" class="btn btn-sm btn-link">Cancel</button>
                </p>
            @endif

            @guest
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" wire:model="author_name"
                            class="form-control @error('author_name') is-invalid @enderror" placeholder="Your Name">
                        @error('author_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <input type="email" wire:model="author_email"
                            class="form-control @error('author_email') is-invalid @enderror" placeholder="Your Email">
                        @error('author_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            @endguest

            <textarea wire:model="content" rows="4" class="form-control @error('content') is-invalid @enderror"
                placeholder="Your comment..."></textarea>
            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror

            <button wire:click="submitComment" class="btn btn-primary mt-3">
                <i class="bi bi-send"></i> Submit Comment
            </button>
        </div>
    </div>

    <!-- Comments List -->
    <div class="comments-list">
        @forelse($comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $comment->user->name ?? $comment->author_name }}</strong>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mt-2 mb-2">{{ $comment->content }}</p>
                    <button wire:click="reply({{ $comment->id }})" class="btn btn-sm btn-link p-0">
                        <i class="bi bi-reply"></i> Reply
                    </button>

                    <!-- Nested Replies -->
                    @if($comment->replies->count())
                        <div class="ms-4 mt-3">
                            @foreach($comment->replies as $reply)
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $reply->user->name ?? $reply->author_name }}</strong>
                                            <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mt-2 mb-0">{{ $reply->content }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted">No comments yet. Be the first to comment!</p>
        @endforelse
    </div>
</div>