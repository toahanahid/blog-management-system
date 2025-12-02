<div>
    <div class="container">
        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <input type="text" wire:model.live="search" class="form-control form-control-lg"
                    placeholder="Search posts...">
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-6">
                <select wire:model.live="selectedCategory" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }} ({{ $category->posts_count }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <select wire:model.live="selectedTag" class="form-select">
                    <option value="">All Tags</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }} ({{ $tag->posts_count }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="row">
            @forelse($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card post-card h-100">
                        @if($post->featured_image)
                            <img src="{{ Storage::url($post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}"
                                style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center"
                                style="height: 200px;">
                                <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark stretched-link">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            <p class="card-text text-muted">{{ Str::limit($post->excerpt, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-person"></i> {{ $post->user->name }}
                                </small>
                                <small class="text-muted">
                                    <i class="bi bi-eye"></i> {{ $post->views_count }}
                                </small>
                            </div>
                            @if($post->category)
                                <span class="badge bg-primary mt-2">{{ $post->category->name }}</span>
                            @endif
                            @foreach($post->tags as $tag)
                                <span class="badge bg-secondary mt-2">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <div class="card-footer text-muted">
                            <small>{{ $post->publish_at?->diffForHumans() ?? $post->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No posts found. Try adjusting your search or filters.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>
