@extends('layout.app')
@section('title')
<title>Редактирование задачи #{{ $task->id }}</title>
@endsection
@section('content')
<h1>Редактирование задачи #{{ $task->id }}</h1>

<form action="{{ route('tasks.update', $task) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="title">Название задачи <span style="color: red;">*</span></label>
        <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required>
        @error('title')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Описание</label>
        <textarea name="description" id="description" rows="6">{{ old('description', $task->description) }}</textarea>
        @error('description')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="status">Статус</label>
        <select name="status" id="status">
            <option value="new" {{ old('status', $task->status) == 'new' ? 'selected' : '' }}>Новая</option>
            <option value="progress" {{ old('status', $task->status) == 'progress' ? 'selected' : '' }}>В работе</option>
            <option value="complete" {{ old('status', $task->status) == 'complete' ? 'selected' : '' }}>Выполнена</option>
        </select>
        @error('status')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div style="margin-top: 30px;">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="{{ route('tasks.show', $task) }}" class="btn btn-secondary">Отмена</a>
    </div>
</form>
@endsection
