@extends('main-layout') 

@section('title', 'Редактировать задачу')

@section('content') 

    <h1>Редактировать задачу</h1>

    <form method="POST" action="{{ route('update', $task->id) }}">
        @csrf

        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $task->title }}">
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ $task->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="deadline">Дедлайн</label>
            <input type="datetime-local" name="deadline" id="deadline" class="form-control" value="{{ $task->deadline->format('Y-m-d\TH:i') }}">
        </div>

        <div class="form-group">
            <label for="status">Статус</label>
            <select name="status" id="status" class="form-control" value="{{ $task->status }}">
                <option value="В процессе" >В процессе</option>
                <option value="Завершено" >Завершено</option>
                <option value="Не завершено" >Не завершено</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="/index" class="btn btn-secondary">Отмена</a>
    </form>

@endsection