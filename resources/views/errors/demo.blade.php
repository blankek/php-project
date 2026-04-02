@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Ошибки HTTP</h3>

    <div class="mb-4">
        @foreach($errors as $code => $info)
            <a href="{{ url('/errors') }}?code={{ $code }}"
               class="btn btn-sm {{ $activeCode === $code ? 'btn-secondary' : ($code >= 500 ? 'btn-danger' : 'btn-warning') }} me-1 mb-1">
                {{ $code }}
            </a>
        @endforeach
        @if($activeCode)
            <a href="{{ url('/errors') }}" class="btn btn-sm btn-outline-secondary mb-1">Сбросить</a>
        @endif
    </div>

    @if($activeCode && $activeError)
        <h4>{{ $activeCode }} - {{ $activeError['title'] }}</h4>
        <p class="text-muted">{{ $activeError['description'] }}</p>

        <table class="table table-bordered w-auto">
            <thead class="table-light">
                <tr><th>Заголовок</th><th>Значение</th></tr>
            </thead>
            <tbody>
                <tr><td>Status</td><td>{{ $activeCode }} {{ $activeError['title'] }}</td></tr>
                @foreach(array_merge($activeError['headers'], ['X-Error-Code' => (string)$activeCode, 'Cache-Control' => 'no-store, no-cache']) as $header => $value)
                    <tr><td>{{ $header }}</td><td>{{ $value }}</td></tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">Нажмите на код ошибки, чтобы увидеть информацию.</p>
    @endif
</div>
@endsection
