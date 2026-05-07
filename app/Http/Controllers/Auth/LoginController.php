<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $email    = strtolower(trim($request->input('email')));
        $password = $request->input('password');

        $validEmail    = strtolower(trim(env('ADMIN_EMAIL', '')));
        $validPassword = env('ADMIN_PASSWORD', '');

        if ($email !== $validEmail || $password !== $validPassword) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->put('admin_authenticated', true);

        return redirect('/admin');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_authenticated');

        return redirect('/');
    }
}
