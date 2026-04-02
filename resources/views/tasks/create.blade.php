@extends('layout.app')
@section('title')
<title>Создание задачи</title>
@endsection
@section('content')
<h1>Создание задачи</h1>

<form action="{{ route('tasks.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="title">Название задачи <span style="color: red;">*</span></label>
        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Введите название задачи..." required>
        @error('title')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Описание</label>
        <textarea name="description" id="description" placeholder="Описание задачи...">{{ old('description') }}</textarea>
        @error('description')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="status">Статус</label>
        <select name="status" id="status">
            <option value="new" {{ old('status') == 'new' ? 'selected' : '' }}>Новая</option>
            <option value="progress" {{ old('status') == 'progress' ? 'selected' : '' }}>В работе</option>
            <option value="complete" {{ old('status') == 'complete' ? 'selected' : '' }}>Выполнена</option>
        </select>
        @error('status')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div style="margin-top: 30px;">
        <button type="submit" class="btn btn-primary">Создать задачу</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Отмена</a>
    </div>
</form>
@endsection
