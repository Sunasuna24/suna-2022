<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterConteroller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function() {
    Route::get('/', function () {return view('top');})->name('top');
    Route::get('/register', [RegisterConteroller::class, 'index'])->name('register');
    Route::post('/register', [RegisterConteroller::class, 'register']);
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/post', [PostController::class, 'index'])->name('post.create');
    Route::post('/post', [PostController::class, 'create']);

    Route::get('/posts/{post}', [PostController::class, 'show'])->whereNumber('post')->name('post.show');
    Route::post('/posts/{post}', [PostController::class, 'edit'])->whereNumber('post');

    Route::get('/mypost', [HomeController::class, 'mypost'])->name('mypost');
});
