<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Вход | DobroNews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .btn-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        .btn-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
        }
        .text-primary {
            color: #4f46e5 !important;
        }
        .card {
            border: 1px solid #eee;
            border-radius: 1rem;
            overflow: hidden;
        }
        .form-control {
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            padding: 0.75rem 1rem;
        }
        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.1);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-light bg-white border-bottom py-3">
    <div class="container">
        <a href="{{ route('news.index') }}" class="navbar-brand fw-bold text-primary mb-0 h1 text-decoration-none">
            <i class="fas fa-newspaper me-2"></i>DobroNews
        </a>
    </div>
</nav>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="fw-bold mb-0 text-center">
                        <i class="fas fa-sign-in-alt text-primary me-2"></i>Вход в аккаунт
                    </h4>
                    <p class="text-muted text-center small mt-2">Введите свои данные для входа</p>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="login" class="form-label fw-bold">Логин</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-3">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text"
                                       class="form-control @error('login') is-invalid @enderror"
                                       id="login"
                                       name="login"
                                       value="{{ old('login') }}"
                                       placeholder="Введите логин"
                                       required
                                       autofocus>
                            </div>
                            @error('login')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">Пароль</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-3">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       placeholder="Введите пароль"
                                       required>
                            </div>
                            @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label text-muted" for="remember">
                                Запомнить меня
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-bold">
                            <i class="fas fa-arrow-right-to-bracket me-2"></i>Войти
                        </button>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted mb-0">Нет аккаунта?</p>
                        <a href="{{ route('reg') }}" class="btn btn-link text-primary text-decoration-none fw-bold mt-2">
                            Создать аккаунт <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
