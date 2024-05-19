<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Auth::routes();

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/profile', [UserController::class, 'showProfilePage'])->name('profile')->middleware('auth');
Route::post('/profile/{id}/edit', [UserController::class, 'update'])->name('profile.update')->middleware('auth');

Route::get('/', [PostController::class, 'index'])->name('index')->middleware('auth');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::resource('posts', PostController::class);
Route::resource('comments', CommentController::class)->only(['store', 'update', 'edit']);
