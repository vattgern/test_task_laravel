@extends('layout.app')
@section('title')
<title>Задача #{{ $task->id }}</title>
@endsection
@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">← Назад к списку</a>
    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">Редактировать</a>
    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
    </form>
</div>

<div style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
    <h2 style="margin-bottom: 20px;">{{ $task->title }}</h2>

    <div style="display: grid; gap: 15px; margin-bottom: 30px;">
        <div>
            <strong>Статус:</strong><br>
            <span class="status-badge status-{{ str_replace('_', '-', $task->status) }}" style="margin-top: 5px; display: inline-block;">
                {{ \App\Models\Task::STATUSES[$task->status] }}
            </span>
        </div>

        <div>
            <strong>Создано:</strong><br>
            {{ $task->created_at->format('d.m.Y H:i:s') }}
        </div>

        <div>
            <strong>Обновлено:</strong><br>
            {{ $task->updated_at->format('d.m.Y H:i:s') }}
        </div>
    </div>

    @if($task->description)
    <div style="border-top: 2px solid #e0e0e0; padding-top: 20px;">
        <h3>Описание</h3>
        <div style="margin-top: 10px; line-height: 1.6; white-space: pre-wrap;">
            {{ $task->description }}
        </div>
    </div>
    @else
    <div style="border-top: 2px solid #e0e0e0; padding-top: 20px; color: #999;">
        <em>Описание отсутствует</em>
    </div>
    @endif
</div>
@endsection
