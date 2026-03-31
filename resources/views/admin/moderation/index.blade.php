<h1>Новости на модерации</h1>

@if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

<table border="1" width="100%">
    <thead>
        <tr>
            <th>Заголовок</th>
            <th>Автор</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @forelse($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ $post->user->name ?? 'Аноним' }}</td>
                <td>{{ $post->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    <form action="{{ route('admin.moderation.approve', $post) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background: green; color: white;">Одобрить</button>
                    </form>
                    
                    <form action="{{ route('admin.moderation.reject', $post) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background: red; color: white;">Отклонить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Пока нет новостей на проверку.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $posts->links() }}