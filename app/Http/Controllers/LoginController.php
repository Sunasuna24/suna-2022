<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index():View
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->with('error_status', '認証情報が正しくありません。')->withInput();
        }

        $request->session()->regenerate();
        return redirect()->route('home');

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('top');
    }
}
