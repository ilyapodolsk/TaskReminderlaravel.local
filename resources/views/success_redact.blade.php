@extends('main-layout')

@section('title', 'Успешное редактирование профиля')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Успех!</div>

                    <div class="card-body">
                        <p>ПРОФИЛЬ УСПЕШНО ОТРЕДАКТИРОВАН!</p>
                        <a href="{{ route('profile', Auth::id()) }}">ВЕРНУТЬСЯ К ПРОФИЛЮ</a> |
                        <a href="{{ route('index') }}">ВЕРНУТЬСЯ НА ГЛАВНУЮ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection