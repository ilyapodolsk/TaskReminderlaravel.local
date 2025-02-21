<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function profile($id) {
        $user = User::find($id);
        return view('profile', ['user' => $user]);
    }

    public function success_redact() {
        return view('success_redact');
    }

    public function updateProfile(Request $request) {
        if ($request->has('profile_update')) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'birthdate' => 'required|date|before:' . Carbon::now()->subYears(18)->format('Y-m-d'),
                'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id, // Исключаем текущий email
                'password' => 'nullable|string|min:8|confirmed', 
            ]);

            $user = $request->user(); 

            $user->name = $validated['name'];
            $user->birthdate = $validated['birthdate'];
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            return redirect()->route('success_redact');
        }
    }
}
