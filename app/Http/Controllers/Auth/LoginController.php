<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $adminAccountId = session('admin_account_id');

        if (session('admin_authenticated') === true && $adminAccountId && AdminAccount::whereKey($adminAccountId)->exists()) {
            return redirect()->route('admin.dashboard');
        }

        session()->forget(['admin_authenticated', 'admin_account_id']);

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $email = strtolower(trim($request->input('email')));
        $password = $request->input('password');

        $adminAccount = AdminAccount::whereRaw('lower(email) = ?', [$email])->first();

        if (! $adminAccount || ! Hash::check($password, $adminAccount->password)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();
        $request->session()->put('admin_authenticated', true);
        $request->session()->put('admin_account_id', $adminAccount->id);

        return redirect('/admin/dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_authenticated');
        $request->session()->forget('admin_account_id');

        return redirect('/');
    }
}
