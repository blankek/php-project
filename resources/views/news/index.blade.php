<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новости</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div style="display: flex; ">
        <h1 class="mb-4">Новости</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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

                <hr>
                <h6>Комментарии</h6>
                @forelse ($post->postComments as $comment)
                    <div class="border rounded p-2 mb-2">
                        <div class="small text-muted mb-1">
                            {{ $comment->user->name ?? 'Пользователь' }}
                            · {{ $comment->created_at->format('d.m.Y H:i') }}
                        </div>
                        <div>{{ $comment->body }}</div>

                        @auth
                            @if(auth()->id() === $comment->user_id)
                                <form action="{{ route('comments.destroy', ['post' => $post, 'comment' => $comment]) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                @empty
                    <p class="text-muted">Комментариев пока нет.</p>
                @endforelse

                @auth
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="mb-2">
                            <textarea
                                name="body"
                                class="form-control @error('body') is-invalid @enderror"
                                rows="3"
                                placeholder="Оставьте комментарий..."
                                required
                            >{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Отправить</button>
                    </form>
                @else
                    <p class="text-muted mb-0">Войдите в аккаунт, чтобы оставлять комментарии.</p>
                @endauth
            </div>
        </div>
    @empty
        <p>Новости пока отсутствуют.</p>
    @endforelse
</div>
</body>
</html>
