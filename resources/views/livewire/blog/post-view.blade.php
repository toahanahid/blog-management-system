<div>
    <div class="container">
        <article class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Post Header -->
                <h1 class="mb-3">{{ $post->title }}</h1>

                <div class="d-flex justify-content-between align-items-center mb-4 text-muted">
                    <div>
                        <i class="bi bi-person"></i> {{ $post->user->name }}
                        @if($post->category)
                            | <i class="bi bi-folder"></i>
                            <a href="{{ route('blog.category', $post->category->slug) }}">{{ $post->category->name }}</a>
                        @endif
                    </div>
                    <div>
                        <i class="bi bi-calendar"></i>
                        {{ $post->publish_at?->format('M d, Y') ?? $post->created_at->format('M d, Y') }}
                        | <i class="bi bi-eye"></i> {{ $post->views_count }} views
                    </div>
                </div>

                <!-- Featured Image -->
                @if($post->featured_image)
                    <img src="{{ Storage::url($post->featured_image) }}" class="img-fluid rounded mb-4"
                        alt="{{ $post->title }}">
                @endif

                <!-- Content -->
                <div class="post-content mb-5">
                    {!! $post->content !!}
                </div>

                <!-- Tags -->
                @if($post->tags->count())
                    <div class="mb-4">
                        <strong>Tags:</strong>
                        @foreach($post->tags as $tag)
                            <a href="{{ route('blog.tag', $tag->slug) }}" class="badge bg-secondary text-decoration-none">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <hr>

                <!-- Comments Section -->
                <div class="mt-5">
                    <h3 class="mb-4">Comments</h3>
                    @livewire('blog.comment-section', ['postId' => $post->id])
                </div>
            </div>
        </article>
    </div>
</div>