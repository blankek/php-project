@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 text-center py-5">

        @php
            $isServer = $code >= 500;
            $alertClass = $isServer ? 'text-danger' : 'text-warning';
        @endphp

        <div class="{{ $alertClass }} display-1 fw-bold font-monospace mb-3">{{ $code }}</div>
        <h2 class="fw-bold mb-2">{{ $title }}</h2>
        <p class="text-muted mb-4">{{ $description }}</p>

        <div class="card shadow-sm text-start mb-4">
            <div class="card-header fw-semibold d-flex align-items-center gap-2">
                <i class="fas fa-code"></i> Заголовки HTTP-ответа
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0 font-monospace">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Заголовок</th>
                            <th>Значение</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-3 text-primary fw-semibold">Status</td>
                            <td>{{ $code }} {{ $title }}</td>
                        </tr>
                        @foreach($headers as $header => $value)
                            <tr>
                                <td class="ps-3 text-primary fw-semibold">{{ $header }}</td>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <a href="{{ url('/') }}" class="btn btn-primary rounded-pill">
            <i class="fas fa-home me-1"></i> На главную
        </a>
        <a href="{{ url('/errors') }}" class="btn btn-outline-secondary rounded-pill ms-2">
            Демо ошибок
        </a>
    </div>
</div>
@endsection
