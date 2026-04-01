<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/news', [PostController::class, 'newsPage']);
Route::post('/news/{post}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');
Route::delete('/news/{post}/comments/{comment}', [CommentController::class, 'destroy'])
    ->middleware('auth')
    ->name('comments.destroy');

// регистрация авторизация
Route::get('/login', [UserController::class, 'getLogin'])->name('login');
Route::post('/login', [UserController::class, 'postLogin']);

Route::get('/reg', [UserController::class, 'getReg'])->name('reg');
Route::post('/reg', [UserController::class, 'postReg']);

Route::get('/logout', [UserController::class, 'getLogout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');

    Route::post('/moderation/{post}/approve', [ModerationController::class, 'approve'])->name('moderation.approve');
    Route::post('/moderation/{post}/reject', [ModerationController::class, 'reject'])->name('moderation.reject');



});
