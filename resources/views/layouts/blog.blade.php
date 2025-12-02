<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('blog.default_seo.title', 'Blog') }}</title>
    <meta name="description" content="{{ $description ?? config('blog.default_seo.description') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        .blog-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
        }
        .post-card {
            transition: transform 0.2s;
        }
        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .nav-link.active {
            font-weight: bold;
            border-bottom: 2px solid white;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="blog-header">
        <div class="container">
            <div class="row align-items-center py-2">
                <div class="col-md-4">
                    <h2 class="mb-0">
                        <a href="{{ route('home') }}" class="text-white text-decoration-none fw-bold">
                            <i class="bi bi-pencil-square"></i> {{ config('app.name', 'Blog') }}
                        </a>
                    </h2>
                </div>
                <div class="col-md-8">
                    <nav class="navbar navbar-expand-lg navbar-dark">
                        <div class="container-fluid">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="{{ route('home') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                                            <i class="bi bi-house"></i> Home
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('blog.index') }}" class="nav-link {{ Request::is('blog') ? 'active' : '' }}">
                                            <i class="bi bi-journal-text"></i> All Posts
                                        </a>
                                    </li>
                                    @auth
                                        <li class="nav-item">
                                            <a href="{{ route('dashboard') }}" class="nav-link">
                                                <i class="bi bi-speedometer2"></i> Dashboard
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="nav-link btn btn-link text-white text-decoration-none">
                                                    <i class="bi bi-box-arrow-right"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a href="{{ route('login') }}" class="nav-link">
                                                <i class="bi bi-box-arrow-in-right"></i> Login
                                            </a>
                                        </li>
                                    @endauth
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-4">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
