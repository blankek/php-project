<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новости</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Новости</h1>

    @forelse ($posts as $post)
        <div class="card mb-3">
            @if($post->picture)
                <img src="{{ $post->picture }}" class="card-img-top" alt="Изображение новости">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->content }}</p>
                <p class="card-text">
                    <small class="text-muted">
                        Опубликовано: {{ $post->published_at ? $post->published_at->format('d.m.Y H:i') : 'не опубликовано' }}
                    </small>
                </p>
                <p class="card-text">
                    👍 {{ $post->likes ?? 0 }} | 💬 {{ $post->comments ?? 0 }}
                </p>
            </div>
        </div>
    @empty
        <p>Новости пока отсутствуют.</p>
    @endforelse
</div>
</body>
</html>