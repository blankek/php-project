@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark mb-0">Модерация новостей</h1>
        <span class="badge bg-primary rounded-pill px-3 py-2">{{ $posts->total() }} на проверке</span>
    </div>

    @if(session('info'))
        <div class="alert alert-info border-0 shadow-sm rounded-3 mb-4">{{ session('info') }}</div>
    @endif

    <div class="row">
        @forelse ($posts as $post)
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="row g-0">
                        @if($post->picture)
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $post->picture) }}" class="img-fluid h-100 w-100" alt="Изображение" style="object-fit: cover;">
                            </div>
                        @endif
                        <div class="col-md-{{ $post->picture ? '8' : '12' }}">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h3 class="card-title fw-bold mb-0 text-dark">{{ $post->title }}</h3>
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1">Ожидает проверки</span>
                                </div>
                                <p class="card-text text-secondary mb-4" style="white-space: pre-line;">{{ Str::limit($post->content, 300) }}</p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="small text-muted">
                                        <i class="far fa-clock me-1"></i>Создано: {{ $post->created_at->format('d.m.Y H:i') }}
                                    </div>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.moderation.approve', $post) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success px-4 rounded-pill">Опубликовать</button>
                                        </form>
                                        <form action="{{ route('admin.moderation.reject', $post) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger px-4 rounded-pill">Отклонить</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="bg-white rounded-4 p-5 shadow-sm">
                    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                    <h4 class="fw-bold">Все проверено!</h4>
                    <p class="text-muted mb-0">Новостей, ожидающих модерации, пока нет.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection
