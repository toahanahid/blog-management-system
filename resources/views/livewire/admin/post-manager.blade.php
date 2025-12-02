<div>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Manage Posts</h2>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create New Post
            </a>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-6">
                <input type="text" wire:model.live="search" class="form-control" placeholder="Search posts...">
            </div>
            <div class="col-md-6">
                <select wire:model.live="filterStatus" class="form-select">
                    <option value="">All Status</option>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="scheduled">Scheduled</option>
                </select>
            </div>
        </div>

        <!-- Posts Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Comments</th>
                                <th>Views</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td>
                                        <strong>{{ Str::limit($post->title, 40) }}</strong>
                                        @if($post->featured_image)
                                            <i class="bi bi-image text-primary" title="Has featured image"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if($post->category)
                                            <span class="badge bg-primary">{{ $post->category->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>
                                        @if($post->status === 'draft')
                                            <span class="badge bg-secondary">Draft</span>
                                        @elseif($post->status === 'published')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning">Scheduled</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-info">{{ $post->comments_count }}</span></td>
                                    <td>{{ $post->views_count }}</td>
                                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if($post->status === 'published')
                                                <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
                                                    class="btn btn-info" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button wire:click="delete({{ $post->id }})"
                                                onclick="return confirm('Are you sure you want to delete this post?')"
                                                class="btn btn-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                        <p class="mt-2">No posts found. Create your first post!</p>
                                        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i> Create Post
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>