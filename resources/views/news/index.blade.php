@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Заголовок и кнопка "Добавить новость" --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark mb-0">Новости</h1>

        @auth
            @if(auth()->user()->canEdit())
                <a href="{{ route('news.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fas fa-plus me-2"></i>Добавить новость
                </a>
            @endif
        @endauth
    </div>

    {{-- Сообщение об успехе --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Список новостей --}}
    @forelse ($posts as $post)
        <div class="card mb-4 border-0 shadow-sm rounded-4 overflow-hidden">

            {{-- Изображение новости --}}
            @if($post->picture)
                <img src="{{ asset('storage/' . $post->picture) }}" class="card-img-top"
                     alt="Изображение новости" style="max-height: 400px; object-fit: cover;">
            @endif

            <div class="card-body p-4">

                {{-- Заголовок и контент --}}
                <h3 class="card-title fw-bold mb-3">{{ $post->title }}</h3>
                <p class="card-text text-secondary mb-4" style="white-space: pre-line;">
                    {{ $post->content }}
                </p>

                {{-- Автор --}}
                @if($post->user)
                    <p class="text-muted small mb-3">
                        Автор:
                        @auth
                            <a href="{{ route('profile.show', $post->user) }}" class="text-primary text-decoration-none fw-semibold">
                                {{ $post->user->login }}
                            </a>
                        @else
                            <span class="fw-semibold">{{ $post->user->login }}</span>
                        @endauth
                    </p>
                @endif

                {{-- Метки: дата, лайки, комментарии --}}
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge bg-light text-secondary px-3 py-2 rounded-pill">
                        <i class="far fa-calendar-alt me-2"></i>
                        {{ $post->published_at ? $post->published_at->format('d.m.Y H:i') : 'не опубликовано' }}
                    </span>
                    <span class="badge bg-light text-secondary px-3 py-2 rounded-pill d-flex align-items-center gap-2">
                    @auth
                        @php
                            $liked = $post->isLikedBy(auth()->user());
                        @endphp

                        <form action="{{ route('posts.like', $post) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline" 
                                style="color: {{ $liked ? '#dc3545' : '#6c757d' }};">
                                <i class="fas fa-thumbs-up"></i>
                            </button>
                        </form>
                    @else
                        <i class="fas fa-thumbs-up text-secondary"></i>
                    @endauth

                    <span>{{ $post->likesRelation()->count() }}</span>
                </span>
                </div>

                <hr class="my-4 opacity-10">

                {{-- Комментарии --}}
                <h5 class="fw-bold mb-3">Комментарии</h5>
                @forelse ($post->postComments as $comment)
                    <div class="bg-light rounded-4 p-3 mb-3 border-0">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="small fw-bold text-primary">
                                {{ $comment->user->login ?? 'Пользователь' }}
                                <span class="text-muted fw-normal ms-2">· {{ $comment->created_at->format('d.m.Y H:i') }}</span>
                            </div>

                            @auth
                                @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
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

                {{-- Форма добавления комментария --}}
                @auth
                    @if(auth()->user()->canInteract())
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
                            <p class="text-muted mb-0 small">У вас нет прав для добавления комментариев.</p>
                        </div>
                    @endif
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