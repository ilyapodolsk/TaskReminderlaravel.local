<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        // Пользователь вошел в систему, редирект на главную
        return redirect()->route('index');
    } else {
        // Пользователь не вошел в систему, редирект на вход
        return redirect()->route('login');
    }
});

Route::get('/index', [TaskController::class, 'index'])->name('index');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::get('/create', [TaskController::class, 'create'])->name('create');
Route::post('/create', [TaskController::class, 'create']);
Route::any('/success', [TaskController::class, 'success'])->name('success');
Route::any('/success_update', [TaskController::class, 'success_update'])->name('success_update');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/redact/{task}', [TaskController::class, 'redact'])->name('redact');
Route::post('/update/{task}', [TaskController::class, 'update'])->name('update');

Route::any('/profile/{id}', [ProfileController::class, 'profile'])->name('profile');
Route::post('/updateProfile', [ProfileController::class, 'updateProfile'])->name('updateProfile');
Route::any('/success_redact', [ProfileController::class, 'success_redact'])->name('success_redact');

Route::get('/notifications', [TaskController::class, 'notifications'])->name('notifications');