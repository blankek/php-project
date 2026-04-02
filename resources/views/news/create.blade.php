@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4 border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h4 class="mb-0 fw-bold">Создать новость</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" id="news-form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Заголовок</label>
                        <input type="text" name="title" class="form-control" required placeholder="Введите заголовок...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Текст новости</label>
                        <textarea name="content" class="form-control" rows="6" required placeholder="О чем новость?"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Изображение</label>
                        <input type="file" name="picture" class="form-control">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" name="action" value="draft" class="btn btn-outline-primary px-4">Сохранить черновик</button>
                        <button type="submit" name="action" value="moderation" class="btn btn-primary px-4">Отправить на модерацию</button>
                        <a href="{{ route('news.index') }}" class="btn btn-link text-muted px-3">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Черновики -->
        <div class="card border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 fw-bold">Ваши черновики</h5>
            </div>
            <div class="card-body p-4">
                @forelse ($drafts as $draft)
                    <div class="mb-4 border-bottom pb-3">
                        <h6 class="fw-bold mb-1">{{ $draft->title }}</h6>
                        <p class="text-muted small mb-2">{{ Str::limit($draft->content, 60) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">
                                📅 {{ $draft->created_at->format('d.m.Y') }}
                                @if($draft->status === 'returned')
                                    <span class="badge bg-danger ms-1">Возврат от админа</span>
                                @endif
                            </span>
                            <div class="d-flex gap-1">
                                <a href="{{ route('news.edit', $draft) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('news.submit', $draft) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary">На модерацию</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-2">
                        <p class="text-muted small mb-0">Черновиков нет.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- На модерации -->
        <div class="card border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="mb-0 fw-bold">На модерации</h5>
            </div>
            <div class="card-body p-4">
                @forelse ($pendingPosts as $pending)
                    <div class="mb-3 border-bottom pb-2">
                        <h6 class="fw-bold mb-1 text-muted">{{ $pending->title }}</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-light text-dark fw-normal">Ожидает проверки</span>
                            <span class="text-muted small">{{ $pending->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-2">
                        <p class="text-muted small mb-0">Пусто.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
