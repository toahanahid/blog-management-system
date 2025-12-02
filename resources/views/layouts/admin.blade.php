<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white vh-100 position-fixed" style="width: 250px;">
            <div class="p-3">
                <h4>Blog Admin</h4>
            </div>
            <nav class="nav flex-column">
                <a href="{{ route('dashboard') }}" class="nav-link text-white">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.posts') }}" class="nav-link text-white">
                    <i class="bi bi-file-text"></i> Posts
                </a>
                <a href="{{ route('admin.categories') }}" class="nav-link text-white">
                    <i class="bi bi-folder"></i> Categories
                </a>
                <a href="{{ route('admin.tags') }}" class="nav-link text-white">
                    <i class="bi bi-tags"></i> Tags
                </a>
                <a href="{{ route('admin.media') }}" class="nav-link text-white">
                    <i class="bi bi-image"></i> Media
                </a>
                <a href="{{ route('admin.comments') }}" class="nav-link text-white">
                    <i class="bi bi-chat"></i> Comments
                </a>
                <hr class="text-white">
                <a href="{{ route('blog.index') }}" class="nav-link text-white" target="_blank">
                    <i class="bi bi-eye"></i> View Blog
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link text-white border-0 bg-transparent w-100 text-start">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1" style="margin-left: 250px;">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <span class="navbar-brand">Welcome, {{ auth()->user()->name }}</span>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>

</html>