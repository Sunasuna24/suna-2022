<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterConteroller extends Controller
{
    public function index(): View
    {
        return view('Auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'min:8'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }
}
