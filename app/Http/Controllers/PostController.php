<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index():View
    {
        return view('post');
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'status' => ['numeric', 'between:0,1']
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
            'status' => boolval($request->status)
        ]);

        return redirect()->route('post.show', $post->id);
    }

    public function show(Post $post):View
    {
        return view('detail', compact('post'));
    }

    public function edit(Post $post, Request $request)
    {
        if ($post->user->id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'status' => ['numeric', 'between:0,1'],
        ]);

        $post->title = $request->title;
        $post->body = $request->body;
        $post->status = boolval($request->status);
        $post->save();

        return redirect()->route('post.show', $post->id)->with('success_status', '記事を更新しました。');
    }
}
