@extends('main-layout') 

@section('title', 'Создать новую задачу') 

@section('content')

    <h1>Создать новую задачу</h1>

            @if ($errors->any())
                @foreach ($errors->all() as $message)
                    <p class="message">{{ $message }}</p>
                @endforeach
            @endif

    <form method="POST" action="{{ route('create') }}">
        @csrf
        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea name="description" id="description" class="form-control" rows="3" value="{{ old('description') }}"></textarea>
        </div>

        <div class="form-group">
            <label for="deadline">Дедлайн</label>
            <input type="datetime-local" name="deadline" id="deadline" class="form-control" value="{{ old('deadline') }}" >
        </div>

        <div class="form-group">
            <label for="status">Статус</label>
            <select name="status" id="status" class="form-control">
                <option value="В процессе">В процессе</option>
                <option value="Завершено">Завершено</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('index') }}" class="btn btn-secondary">Отмена</a>
    </form>

@endsection