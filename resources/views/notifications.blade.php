@extends('main-layout') 

@section('title', 'Уведомления') 

@section('content') 

    <h1>Уведомления о задачах</h1>

    @php
    $hasActiveTasks = false; 
    @endphp

    <ul class="list-group">
        @foreach($tasks as $task)
            @if($task->status == 'В процессе')
                @php
                    $hasActiveTasks = true; 
                @endphp

                <li class="list-group-item">
                    <h5>{{ $task->title }}</h5>

                    @php
                        $deadline = \Carbon\Carbon::parse($task->deadline);
                        $formattedDeadline = $deadline->format('d.m.Y H:i'); 
                        $daysRemaining = now()->diffInDays($deadline, false);
                    @endphp

                    <p>Дедлайн: {{ $formattedDeadline }}</p>

                    @if($daysRemaining < 0)
                    <span class="urgent">Просрочено!</span>
                    <br>
                    <span class="check-status">Проверьте статус задачи</span>
                    @elseif($daysRemaining < 1)
                    <span class="urgent">СРОЧНО!</span>
                    <br>
                    <span class="check-status">Проверьте статус задачи</span>
                    @elseif($daysRemaining < 3)
                    <span class="soon">Скоро истекает!</span>
                    <br>
                    <span class="check-status">Проверьте статус задачи</span>
                    @endif

                    <a href="{{ route('redact', $task->id) }}" class="btn btn-sm btn-primary">Перейти к задаче</a>
                </li>
            @endif
        @endforeach
    </ul>

    @if($hasActiveTasks == false)
        <p>У вас нет активных задач</p>
    @endif
@endsection 