<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reminder\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

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

Route::get('/reminder', function () {
    return view('reminder.index');
 })->name('reminder');
 

Route::get('/home', function () {
   return view('home');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/users/{user:username}/posts', [UserPostController::class, 'index'])->name('users.posts');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

Route::get('/posts', function () {
    return view('posts.index');
});

// Route::get('/posts', [PostController::class, 'index'])->name('posts');
// Route::get('/posts_vue', [PostController::class, 'index_vue'])->name('posts_vue');
// Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
// Route::post('/posts', [PostController::class, 'store']);
// Route::post('/posts_vue', [PostController::class, 'store_vue']);
// Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
// Route::delete('/posts_vue/{post}', [PostController::class, 'destroy_vue'])->name('posts_vue.destroy');

Route::resource('posts', PostController::class);

// Route::post('/posts/{id}/likes', [PostLikeController::class, 'store']) -> name('posts.likes') ;
Route::post('/posts/{post}/likes', [PostLikeController::class, 'store'])->name('posts.likes');
Route::delete('/posts/{post}/likes', [PostLikeController::class, 'destroy'])->name('posts.likes');
