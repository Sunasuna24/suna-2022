<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index():View
    {
        $posts = Post::published()->get();

        return view('home', compact('posts'));
    }

    public function mypost():View
    {
        $posts = Post::where('user_id', Auth::id())->get();

        return view('mypost', compact('posts'));
    }
}
