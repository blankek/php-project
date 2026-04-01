<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel News') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; }
        .card { border: 1px solid #eee; }
        .btn-primary { background-color: #4f46e5; border-color: #4f46e5; }
        .btn-primary:hover { background-color: #4338ca; border-color: #4338ca; }
        .text-primary { color: #4f46e5 !important; }
    </style>
</head>
<body>
<nav class="navbar navbar-light bg-white border-bottom py-3">
    <div class="container">
        <a href="{{ route('news.index') }}" class="navbar-brand fw-bold text-primary mb-0 h1 text-decoration-none">
            <i class="fas fa-newspaper me-2"></i>DobroNews
        </a>
        <div class="d-flex gap-3">
            <a href="{{ route('profile.index') }}" class="btn btn-primary rounded-pill">
                <i class="fas fa-user me-1"></i>Профиль
            </a>
            @auth
                <form  method="get" action="{{ route('logout') }}" >
                    @csrf
                    <button class="btn btn-primary rounded-pill" type="submit" >Выйти</button>
                </form>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary rounded-pill">
                    <i class="fas fa-user me-1"></i>Вход
                </a>

            @endguest
        </div>
    </div>
</nav>

<main class="container py-4">
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-0 mb-4">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info border-0 rounded-0 mb-4">{{ session('info') }}</div>
    @endif
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
