@extends('layouts.app')

@section('content')
<div class="row g-4 justify-content-center">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="text-white p-4 text-center" style="background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);">
                <img src="{{ $user->getAvatarUrl() }}" alt="Аватар"
                     style="width:120px;height:120px;object-fit:cover;border-radius:50%;border:4px solid #fff;">
                <h3 class="fw-bold mt-3 mb-1">{{ $user->login }}</h3>
                <p class="text-white-50 mb-0">
                    <i class="fas fa-calendar-alt me-1"></i>Зарегистрирован: {{ $user->getFormattedCreatedAt() }}
                </p>
            </div>
            <div class="card-body p-4">
                @if($user->bio)
                    <h5 class="fw-bold mb-2">О себе</h5>
                    <p class="text-muted">{{ $user->bio }}</p>
                @else
                    <p class="text-muted fst-italic">Пользователь ничего не написал о себе.</p>
                @endif

                @if($user->gender)
                    <p class="mb-0 text-muted small">
                        <i class="fas fa-{{ $user->gender === 'male' ? 'mars' : 'venus' }} me-1"></i>
                        {{ $user->gender === 'male' ? 'Мужской' : 'Женский' }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
