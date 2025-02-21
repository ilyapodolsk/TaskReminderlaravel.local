@extends('main-layout')

@section('title', 'Успешное редактирование задачи') 

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Успех!</div>

                    <div class="card-body">
                        <p>ЗАДАЧА УСПЕШНО ОТРЕДАКТИРОВАНА</p>
                        <a href="{{ route('index') }}">ВЕРНУТЬСЯ НА ГЛАВНУЮ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection