<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index():View
    {
        $posts = Post::all();

        return view('home', compact('posts'));
    }
}
