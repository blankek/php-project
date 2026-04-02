@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark mb-0">Управление пользователями</h1>
        <span class="badge bg-primary rounded-pill px-3 py-2">{{ $users->total() }} пользователей</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 border-0">Логин</th>
                        <th class="px-4 py-3 border-0">Текущая роль</th>
                        <th class="px-4 py-3 border-0 text-end">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-bold text-dark">{{ $user->login }}</div>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $badgeClass = match($user->role) {
                                        'admin' => 'bg-danger',
                                        'moderator' => 'bg-warning text-dark',
                                        'editor' => 'bg-primary',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }} rounded-pill px-3 py-1">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <form action="{{ route('admin.roles.update', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="role" value="moderator">
                                        <button type="submit" class="btn btn-sm btn-outline-warning {{ $user->role === 'moderator' ? 'disabled' : '' }}">
                                            Модератор
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.roles.update', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="role" value="editor">
                                        <button type="submit" class="btn btn-sm btn-outline-primary {{ $user->role === 'editor' ? 'disabled' : '' }}">
                                            Редактор
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.roles.update', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="role" value="reader">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary {{ $user->role === 'reader' ? 'disabled' : '' }}">
                                            Читатель
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.roles.update', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="role" value="admin">
                                        <button type="submit" class="btn btn-sm btn-outline-danger {{ $user->role === 'admin' ? 'disabled' : '' }}" onclick="return confirm('Вы уверены, что хотите сделать этого пользователя администратором?')">
                                            Админ
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
