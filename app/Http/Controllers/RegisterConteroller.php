<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RegisterConteroller extends Controller
{
    public function index(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): View
    {
        $request->validate([
            'username' => ['required'],
            'email' => ['required'],
            'password' => ['required']
        ]);
    }
}
