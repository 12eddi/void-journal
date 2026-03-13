<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PollController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;

Route::post('/articles/{article}/like', [LikeController::class, 'toggleArticle'])->name('articles.like');
Route::post('/comments/{comment}/like', [LikeController::class, 'toggleComment'])->name('comments.like');

// Public
Route::get('/', [ArticleController::class, 'index'])->name('home');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::middleware('auth')->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Polls
Route::get('/polls', [PollController::class, 'index'])->name('polls.index');
Route::middleware('auth')->group(function () {
    Route::get('/polls/create', [PollController::class, 'create'])->name('polls.create');
    Route::post('/polls', [PollController::class, 'store'])->name('polls.store');
    Route::post('/polls/{poll}/vote', [PollController::class, 'vote'])->name('polls.vote');
    Route::delete('/polls/{poll}', [PollController::class, 'destroy'])->name('polls.destroy');
});
Route::get('/polls/{poll}', [PollController::class, 'show'])->name('polls.show');

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/promote', [AdminController::class, 'promoteUser'])->name('users.promote');
    Route::post('/users/{user}/demote', [AdminController::class, 'demoteUser'])->name('users.demote');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});