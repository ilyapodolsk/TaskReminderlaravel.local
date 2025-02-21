<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(Request $request) {
        
        $query = Task::where('user_id', Auth::id());
    
        $specificDate = $request->input('specific_date');
        $dateFilter = $request->input('date');
        $statusFilter = $request->input('status');
    
        if($specificDate) {
            $query->WhereDate('deadline', $specificDate);
        } 
        elseif (isset($dateFilter) && $dateFilter != 'all') {

            switch ($dateFilter) {
                case 'сегодня':
                    $query->whereDate('deadline', Carbon::today());
                    break;
                case 'завтра':
                    $query->whereDate('deadline', Carbon::tomorrow());
                    break;
                case 'на этой неделе':
                    $query->whereBetween('deadline', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'на следующей неделе':
                    $query->whereBetween('deadline', [Carbon::now()->addWeek()->startOfWeek(), Carbon::now()->addWeek()->endOfWeek()]);
                    break;
                default:
                    break;
            }
        }
    
        if (isset($statusFilter) && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }
    
        $tasks = $query->orderByDesc('deadline')->get();

        return view('index', ['tasks' => $tasks]);
    }

    public function destroy(Task $task) {
        $task->delete();

        return redirect()->route('index')->with('success', 'Задача успешно удалена.');
    }

    public function create(Request $request) {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'title' => 'required|string|max:35',
                'description' => 'required|string|max:255',
                'deadline' => 'required',
                'status' => 'required|in:В процессе,Завершено',
            ], [
                'title.required' => 'Пожалуйста, укажите название задачи!',
                'title.string' => 'Название задачи должно быть строкой!',
                'title.max' => 'Название задачи не должно превышать 35 символов!',
                'description.required' => 'Пожалуйста, укажите описание задачи!',
                'description.string' => 'Описание задачи должно быть строкой!',
                'description.max' => 'Описание задачи не должно превышать 255 символов!',
                'deadline.required' => 'Пожалуйста, укажите срок выполнения задачи!',
                'status.required' => 'Пожалуйста, укажите статус задачи!',
                'status.in' => 'Укажите один из допустимых статусов: "В процессе", "Завершено"',
            ]);
            $task = new Task();
            $task->title = $validated['title'];
            $task->description = $validated['description'];
            $task->deadline = $validated['deadline'];
            $task->status = $validated['status'];
            $task->user_id = Auth::id();
            $task->save();
            return redirect()->route('success');
        }

        return view('create');
    }

    public function success() {
        return view('success');
    }


    public function redact($id) {
        $task = Task::find($id);
        return view('redact', ['task' => $task]);
    }

    public function success_update() {
        return view('success_update');
    }

    public function update(Request $request, Task $task) { 
        $validated = $request->validate([
            'title' => 'required|string|max:35',
            'description' => 'required|string|max:255',
            'deadline' => 'required',
            'status' => 'required|in:В процессе,Завершено,Не завершено',
        ]);
    
        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->deadline = $validated['deadline'];
        $task->status = $validated['status'];
        $task->save();
    
        return redirect()->route('success_update');
    }

    public function notifications() {
        $tasks = Task::where('user_id', Auth::id())->orderBy('deadline')->get();
        return view('notifications', ['tasks' => $tasks]);
    }
}