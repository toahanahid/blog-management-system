<div>
    <div class="container">
        <h2 class="mb-4">Posts tagged with "{{ $tag->name }}"</h2>

        <div class="row">
            @forelse($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card post-card h-100">
                        @if($post->featured_image)
                            <img src="{{ Storage::url($post->featured_image) }}" class="card-img-top"
                                style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            <p class="card-text text-muted">{{ Str::limit($post->excerpt, 100) }}</p>
                            @if($post->category)
                                <span class="badge bg-primary">{{ $post->category->name }}</span>
                            @endif
                        </div>
                        <div class="card-footer text-muted">
                            <small>{{ $post->publish_at?->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No posts with this tag yet.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>