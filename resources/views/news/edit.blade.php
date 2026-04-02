@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4 border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h4 class="mb-0 fw-bold">Редактировать новость</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('news.update', $post) }}" method="POST" enctype="multipart/form-data" id="news-form">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Заголовок</label>
                        <input type="text" name="title" class="form-control" value="{{ $post->title }}" required placeholder="Введите заголовок...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Текст новости</label>
                        <textarea name="content" class="form-control" rows="6" required placeholder="О чем новость?">{{ $post->content }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Изображение</label>
                        @if($post->picture)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $post->picture) }}" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @endif
                        <input type="file" name="picture" class="form-control">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" name="action" value="draft" class="btn btn-outline-primary px-4">Сохранить изменения</button>
                        <button type="submit" name="action" value="moderation" class="btn btn-primary px-4">Отправить на модерацию</button>
                        <a href="{{ route('news.create') }}" class="btn btn-link text-muted px-3">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
