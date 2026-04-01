@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4 border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h4 class="mb-0 fw-bold">Создать новость</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
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
                        <button type="submit" name="save_draft" class="btn btn-outline-primary px-4">Сохранить черновик</button>
                        <button type="submit" name="submit_moderation" class="btn btn-primary px-4">Отправить на модерацию</button>
                        <a href="{{ route('news.index') }}" class="btn btn-link text-muted px-3">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0">
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
                            </span>
                            <form action="{{ route('news.submit', $draft) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary">На модерацию</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-muted small mb-0">У вас пока нет черновиков.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
