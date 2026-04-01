@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark mb-0">Новости</h1>
        <a href="{{ route('news.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i>Добавить новость
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">{{ session('success') }}</div>
    @endif

    @forelse ($posts as $post)
        <div class="card mb-4 border-0 shadow-sm rounded-4 overflow-hidden">
            @if($post->picture)
                <img src="{{ asset('storage/' . $post->picture) }}" class="card-img-top" alt="Изображение новости" style="max-height: 400px; object-fit: cover;">
            @endif
            <div class="card-body p-4">
                <h3 class="card-title fw-bold mb-3">{{ $post->title }}</h3>
                <p class="card-text text-secondary mb-4" style="white-space: pre-line;">{{ $post->content }}</p>
                
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge bg-light text-secondary px-3 py-2 rounded-pill">
                        <i class="far fa-calendar-alt me-2"></i>{{ $post->published_at ? $post->published_at->format('d.m.Y H:i') : 'не опубликовано' }}
                    </span>
                    <span class="badge bg-light text-secondary px-3 py-2 rounded-pill">
                        👍 {{ $post->likes ?? 0 }}
                    </span>
                    <span class="badge bg-light text-secondary px-3 py-2 rounded-pill">
                        💬 {{ $post->comments ?? 0 }}
                    </span>
                </div>

                <hr class="my-4 opacity-10">
                
                <h5 class="fw-bold mb-3">Комментарии</h5>
                @forelse ($post->postComments as $comment)
                    <div class="bg-light rounded-4 p-3 mb-3 border-0">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="small fw-bold text-primary">
                                {{ $comment->user->name ?? 'Пользователь' }}
                                <span class="text-muted fw-normal ms-2">· {{ $comment->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                            @auth
                                @if(auth()->id() === $comment->user_id)
                                    <form action="{{ route('comments.destroy', ['post' => $post, 'comment' => $comment]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none small">Удалить</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        <div class="text-dark">{{ $comment->body }}</div>
                    </div>
                @empty
                    <p class="text-muted small italic">Комментариев пока нет. Будьте первым!</p>
                @endforelse

                @auth
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <textarea
                                name="body"
                                class="form-control rounded-3 border-0 bg-light p-3 @error('body') is-invalid @enderror"
                                rows="2"
                                placeholder="Оставьте комментарий..."
                                required
                            >{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">Отправить</button>
                    </form>
                @else
                    <div class="bg-light rounded-3 p-3 text-center mt-4">
                        <p class="text-muted mb-0 small">Войдите в аккаунт, чтобы оставлять комментарии.</p>
                    </div>
                @endauth
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="far fa-newspaper fa-4x text-muted mb-3"></i>
            <p class="text-muted">Новости пока отсутствуют.</p>
        </div>
    @endforelse
</div>
@endsection
