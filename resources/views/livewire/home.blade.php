<div>
    <!-- Hero Slider Section -->
    <section class="hero-slider mb-5 pt-2 w-100">
            <div class="swiper featured-posts-slider">
                <div class="swiper-wrapper">
                    @forelse($featuredPosts as $post)
                        <div class="swiper-slide">
                            <div class="hero-slide"
                                style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('{{ $post->featured_image ? Storage::url($post->featured_image) : 'https://via.placeholder.com/1200x600/667eea/ffffff?text=Blog+Post' }}') center/cover; border-radius:0px 0px;">
                                <div class="hero-content">
                                    @if($post->category)
                                        <span class="badge bg-primary mb-3">{{ $post->category->name }}</span>
                                    @endif
                                    <h1 class="display-4 fw-bold text-white mb-3">{{ $post->title }}</h1>
                                    <p class="lead text-white mb-4">{{ Str::limit($post->excerpt, 150) }}</p>
                                    <div class="text-white mb-4">
                                        <i class="bi bi-person-circle me-2"></i>
                                        <span class="me-3">{{ $post->user->name }}</span>
                                        <i class="bi bi-calendar me-2"></i>
                                        <span
                                            class="me-3">{{ $post->publish_at?->format('M d, Y') ?? $post->created_at->format('M d, Y') }}</span>
                                        <i class="bi bi-eye me-2"></i>
                                        <span>{{ $post->views_count }} views</span>
                                    </div>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-light btn-lg">
                                        Read More <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="hero-slide" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="hero-content text-center">
                                    <h1 class="display-3 fw-bold text-white mb-3">Welcome to Our Blog</h1>
                                    <p class="lead text-white mb-4">Discover amazing stories and insights</p>
                                    <a href="{{ route('blog.index') }}" class="btn btn-light btn-lg">Explore Posts</a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
    </section>

    <!-- Categories Section -->
    @if($categories->count())
        <section class="categories-section py-4 bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <h5 class="mb-0"><i class="bi bi-folder"></i> Categories:</h5>
                    </div>
                    <div class="col-md-10">
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($categories as $category)
                                <a href="{{ route('blog.category', $category->slug) }}"
                                    class="badge bg-primary text-decoration-none px-3 py-2">
                                    {{ $category->name }} ({{ $category->posts_count }})
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Latest Posts Section -->
    <section class="latest-posts py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Latest Posts</h2>
                <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="row g-4">
                @forelse($latestPosts as $post)
                    <div class="col-md-4">
                        <div class="card post-card h-100 border-0 shadow-sm">
                            @if($post->featured_image)
                                <img src="{{ Storage::url($post->featured_image) }}" class="card-img-top"
                                    alt="{{ $post->title }}" style="height: 220px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center"
                                    style="height: 220px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="bi bi-file-text text-white" style="font-size: 4rem; opacity: 0.5;"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                @if($post->category)
                                    <span class="badge bg-primary mb-2">{{ $post->category->name }}</span>
                                @endif
                                <h5 class="card-title">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark stretched-link">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted">{{ Str::limit($post->excerpt, 100) }}</p>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-person"></i> {{ $post->user->name }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="bi bi-eye"></i> {{ $post->views_count }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <h4>No posts available yet</h4>
                            <p>Check back soon for new content!</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-8">
                    <h2 class="text-white mb-3">Stay Updated</h2>
                    <p class="text-white mb-4">Subscribe to our newsletter to get the latest blog posts delivered to
                        your inbox.</p>
                    <div class="input-group input-group-lg">
                        <input type="email" class="form-control" placeholder="Enter your email address">
                        <button class="btn btn-light" type="button">
                            <i class="bi bi-send"></i> Subscribe
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Swiper CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        .hero-slider {
            margin-top: -2rem;
            margin-bottom: 2rem;
        }

        .hero-slide {
            height: 600px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            max-width: 800px;
            text-align: center;
            padding: 2rem;
            z-index: 2;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            backdrop-filter: blur(10px);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 20px;
        }

        .swiper-pagination-bullet {
            background: white;
            opacity: 0.5;
            width: 12px;
            height: 12px;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
            background: white;
        }

        .post-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .post-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.5em 1em;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.featured-posts-slider', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                speed: 1000,
            });
        });
    </script>
</div>
