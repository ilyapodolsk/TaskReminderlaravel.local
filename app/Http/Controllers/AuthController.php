<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AuthController extends Controller
{
        // Форма регистрации
    public function showRegistrationForm() {
        return view('auth.register');
    }
    
    // Регистрация пользователя
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date|before:' . Carbon::now()->subYears(18)->format('Y-m-d'),
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Пожалуйста, укажите ваше имя!',
            'name.string' => 'Имя должно быть строкой!',
            'name.max' => 'Имя не должно превышать 255 символов!',
            'birthdate.required' => 'Пожалуйста, укажите дату вашего рождения!',
            'birthdate.date' => 'Неверный формат даты рождения!',
            'birthdate.before' => 'Вам должно быть не менее 18 лет!',
            'email.required' => 'Пожалуйста, укажите ваш email!',
            'email.string' => 'Email должен быть строкой!',
            'email.email' => 'Неверный формат email!',
            'email.max' => 'Email не должен превышать 255 символов!',
            'email.unique' => 'Этот email уже зарегистрирован!',
            'password.required' => 'Пожалуйста, укажите пароль!',
            'password.string' => 'Пароль должен быть строкой!',
            'password.min' => 'Пароль должен содержать не менее 8 символов!',
            'password.confirmed' => 'Пароли не совпадают!',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->birthdate = $request->birthdate;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);

        return redirect()->route('index');
    }

    // Форма входа
    public function showLoginForm() {
        return view('auth.login');
    }

    // Войдите в систему 
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('index');
        }

        return back()->withErrors([
            'email' => 'Неверные учетные данные.',
        ]);
    }

    // Выход
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
