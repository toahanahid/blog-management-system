<div>
    <div class="container-fluid py-4">
        <h2 class="mb-4">Dashboard</h2>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <!-- Posts Stats -->
            <div class="col-md-3">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1">Total Posts</h6>
                                <h2 class="mb-0">{{ $stats['total_posts'] }}</h2>
                            </div>
                            <div class="fs-1">
                                <i class="bi bi-file-text"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small>Published: {{ $stats['published_posts'] }}</small> |
                            <small>Draft: {{ $stats['draft_posts'] }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="col-md-3">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1">Categories</h6>
                                <h2 class="mb-0">{{ $stats['total_categories'] }}</h2>
                            </div>
                            <div class="fs-1">
                                <i class="bi bi-folder"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.categories') }}" class="text-white text-decoration-none">
                                <small>Manage →</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <div class="col-md-3">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1">Tags</h6>
                                <h2 class="mb-0">{{ $stats['total_tags'] }}</h2>
                            </div>
                            <div class="fs-1">
                                <i class="bi bi-tags"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.tags') }}" class="text-white text-decoration-none">
                                <small>Manage →</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comments -->
            <div class="col-md-3">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-1">Comments</h6>
                                <h2 class="mb-0">{{ $stats['pending_comments'] }}</h2>
                            </div>
                            <div class="fs-1">
                                <i class="bi bi-chat"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small>Pending Moderation</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-eye fs-1 text-primary"></i>
                        <h3 class="mt-2 mb-0">{{ number_format($stats['total_views']) }}</h3>
                        <p class="text-muted mb-0">Total Views</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-image fs-1 text-success"></i>
                        <h3 class="mt-2 mb-0">{{ $stats['total_media'] }}</h3>
                        <p class="text-muted mb-0">Media Files</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-check fs-1 text-warning"></i>
                        <h3 class="mt-2 mb-0">{{ $stats['scheduled_posts'] }}</h3>
                        <p class="text-muted mb-0">Scheduled Posts</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <!-- Recent Posts -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recent Posts</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @forelse($recent_posts as $post)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ Str::limit($post->title, 40) }}</h6>
                                            <small class="text-muted">
                                                By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                                            </small>
                                            <br>
                                            @if($post->status === 'published')
                                                <span class="badge bg-success mt-1">Published</span>
                                            @elseif($post->status === 'draft')
                                                <span class="badge bg-secondary mt-1">Draft</span>
                                            @else
                                                <span class="badge bg-warning mt-1">Scheduled</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('admin.posts.edit', $post->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-3">No posts yet</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('admin.posts') }}" class="btn btn-sm btn-primary">View All Posts →</a>
                    </div>
                </div>
            </div>

            <!-- Recent Comments -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recent Comments</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @forelse($recent_comments as $comment)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $comment->user->name ?? $comment->author_name }}</h6>
                                            <p class="mb-1">{{ Str::limit($comment->content, 60) }}</p>
                                            <small class="text-muted">
                                                On: {{ Str::limit($comment->post->title, 30) }}
                                            </small>
                                            <br>
                                            @if($comment->status === 'pending')
                                                <span class="badge bg-warning mt-1">Pending</span>
                                            @elseif($comment->status === 'approved')
                                                <span class="badge bg-success mt-1">Approved</span>
                                            @else
                                                <span class="badge bg-danger mt-1">Spam</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-3">No comments yet</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('admin.comments') }}" class="btn btn-sm btn-warning">Moderate Comments →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Create New Post
                            </a>
                            <a href="{{ route('admin.categories') }}" class="btn btn-success">
                                <i class="bi bi-folder-plus"></i> Add Category
                            </a>
                            <a href="{{ route('admin.tags') }}" class="btn btn-info">
                                <i class="bi bi-tag"></i> Add Tag
                            </a>
                            <a href="{{ route('admin.media') }}" class="btn btn-secondary">
                                <i class="bi bi-cloud-upload"></i> Upload Media
                            </a>
                            <a href="{{ route('blog.index') }}" target="_blank" class="btn btn-outline-primary">
                                <i class="bi bi-eye"></i> View Blog
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>