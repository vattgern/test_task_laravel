@extends('layout.app')
@section('title')
<title>Главная</title>
@endsection
@section('content')
{{-- <div class="stats">
    <div class="stat-card">
        <h3>Всего задач</h3>
        <div class="number">{{ $statistics['total'] }}</div>
</div>
<div class="stat-card">
    <h3>Новые</h3>
    <div class="number">{{ $statistics['new'] }}</div>
</div>
<div class="stat-card">
    <h3>В работе</h3>
    <div class="number">{{ $statistics['in_progress'] }}</div>
</div>
<div class="stat-card">
    <h3>Выполнено</h3>
    <div class="number">{{ $statistics['completed'] }}</div>
</div>
</div> --}}

<div class="filters">
    <form method="GET" action="{{ route('tasks.index') }}" style="display: flex; gap: 10px; width: 100%; flex-wrap: wrap;">
        <input type="text" name="search" placeholder="Поиск по названию..." value="{{ request('search') }}" style="flex: 1; min-width: 200px;">

        <select name="status">
            <option value="">Все статусы</option>
            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Новая</option>
            <option value="in_progress" {{ request('status') == 'progress' ? 'selected' : '' }}>В работе</option>
            <option value="completed" {{ request('status') == 'complete' ? 'selected' : '' }}>Выполнена</option>
        </select>

        <select name="sort_by">
            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>По дате создания</option>
            <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>По названию</option>
            <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>По статусу</option>
        </select>

        <select name="sort_direction">
            <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>По убыванию</option>
            <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>По возрастанию</option>
        </select>

        <button type="submit" class="btn btn-primary">Применить</button>

        @if(request('search') || request('status') || request('sort_by'))
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Сбросить</a>
        @endif
    </form>

    <a href="{{ route('tasks.create') }}" class="btn btn-primary" style="white-space: nowrap;">+ Создать задачу</a>
</div>

@if($tasks->count() > 0)
<div style="overflow-x: auto;">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Статус</th>
                <th>Создано</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>
                    <strong>{{ $task->title }}</strong>
                    @if($task->description)
                    <br><small style="color: #666;">{{ Str::limit($task->description, 50) }}</small>
                    @endif
                </td>
                <td>
                    <select class="status-select" data-id="{{ $task->id }}" style="padding: 5px; border-radius: 4px;">
                        <option value="new" {{ $task->status == 'new' ? 'selected' : '' }}>Новая</option>
                        <option value="progress" {{ $task->status == 'progress' ? 'selected' : '' }}>В работе</option>
                        <option value="complete" {{ $task->status == 'complete' ? 'selected' : '' }}>Выполнена</option>
                    </select>
                </td>
                <td>{{ $task->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pen-fill"></i>
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить задачу?')">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="pagination">
    {{ $tasks->withQueryString()->links() }}
</div>
@else
<div style="text-align: center; padding: 60px 20px;">
    <h3>Задачи не найдены</h3>
    <p style="color: #666; margin-top: 10px;">Создайте свою первую задачу, нажав кнопку выше</p>
</div>
@endif
@endsection
