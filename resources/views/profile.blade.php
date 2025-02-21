@extends('main-layout') 

@section('title', 'Профиль') 

@section('content') 

    <h1>Профиль пользователя</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Информация</h5>
            <p>Имя: <b>{{ $user->name }}</b></p>
            <p>Email: <b>{{ $user->email }}</b></p>
            <p>Дата рождения: <b>{{ \Carbon\Carbon::parse($user->birthdate)->format('d-m-Y') }}</b></p>
        </div>
    </div>

    <h2 class="mt-4">Изменить данные</h2>
    <form method="POST" action="{{ route('updateProfile') }}">
        @csrf

        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="birthdate">Дата рождения</label>
            <input type="date" name="birthdate" id="birthdate" class="form-control" value="{{ $user->birthdate }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label for="password">Новый пароль</label>
            <input type="password" name="password" id="password" class="form-control">
            <small class="form-text text-muted">Оставьте пустым, если не хотите менять пароль</small>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <input type="hidden" name="profile_update" value="1">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
    </form>

@endsection 
