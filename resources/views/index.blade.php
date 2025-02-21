@extends('main-layout') 

@section('title', 'Список задач') 

@section('content') 

<h1>Список задач</h1>
        <div class="mb-3">
            <a href="{{ route('create') }}" class="btn btn-primary">Создать новую задачу</a>
        </div>

        <div class="mb-3">
            <form method="GET" action="{{ route('index') }}">
                <label for="status">Фильтр по статусу:</label>
                <select name="status" id="status" class="form-control">
                    <option value="all">Все</option>
                    @php
                        $selectedStatus = request('status');
                    @endphp
                    
                        @php
                            $selectedAttribute = ($selectedStatus == 'В процессе') ? 'selected' : '';
                        @endphp
                        <option value="В процессе" {{ $selectedAttribute }}>В процессе</option>
                    
                    
                        @php
                            $selectedAttribute = ($selectedStatus == 'Завершено') ? 'selected' : '';
                        @endphp
                        <option value="Завершено" {{ $selectedAttribute }}>Завершено</option>
                    
                    
                        @php
                            $selectedAttribute = ($selectedStatus == 'Не завершено') ? 'selected' : '';
                        @endphp
                        <option value="Не завершено" {{ $selectedAttribute }}>Не завершено</option>
                    
                </select>

                <button type="submit" class="btn btn-info mt-2">Применить</button>
            </form>

            <form method="GET" action="{{ route('index') }}">
                <label for="date">Фильтр по дате:</label>
                <select name="date" id="date" class="form-control">
                    <option value="all">Все</option>
                    @php
                        $selectedDate = request('date');
                    @endphp
                    
                        @php
                            $selectedAttribute = ($selectedDate == 'сегодня') ? 'selected' : '';
                        @endphp
                        <option value="сегодня" {{ $selectedAttribute }}>Сегодня</option>
                    
                    
                        @php
                            $selectedAttribute = ($selectedDate == 'завтра') ? 'selected' : '';
                        @endphp
                        <option value="завтра" {{ $selectedAttribute }}>Завтра</option>
                    
                    
                        @php
                            $selectedAttribute = ($selectedDate == 'на этой неделе') ? 'selected' : '';
                        @endphp
                        <option value="на этой неделе" {{ $selectedAttribute }}>На этой неделе</option>
                    
                    
                        @php
                            $selectedAttribute = ($selectedDate == 'на следующей неделе') ? 'selected' : '';
                        @endphp
                        <option value="на следующей неделе" {{ $selectedAttribute }}>На следующей неделе</option>
                    
                </select>

                <div class="form-group">
                    <label for="specific_date">Или выберите дату:</label>
                    <input type="date" name="specific_date" id="specific_date" class="form-control" value="{{ request('specific_date') }}">
                </div>
                
                <button type="submit" class="btn btn-info mt-2">Применить</button>
            </form>
        </div>

        <table class="task-table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Дедлайн</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
                <tbody>
                        @if (count($tasks) === 0)
                            <tr><td colspan="5" class="text-center">Нет задач</td></tr>
                        @else
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ Str::limit($task->description, 50) }}</td>
                                    <td>{{ $task->deadline->format('d.m.Y') }}</td>
                                    <td>{{ $task->status }}</td>
                                    <td class="d-flex align-items-center justify-content-start">
                                        <div>
                                            <a href="{{ route('redact', $task->id) }}" class="btn btn-sm btn-warning mr-2">Редактировать</a>
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                                            </form>
                                        </div>
                                        @if($task->status == 'В процессе' && \Carbon\Carbon::parse($task->deadline)->isPast())
                                            <span class="urgent ml-2" title="Перейдите в Уведомления!">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                </tbody>
        </table>
@endsection