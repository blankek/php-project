<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/news', [PostController::class, 'newsPage'])->name('news.index');
Route::get('/news/create', [PostController::class, 'create'])->name('news.create');
Route::post('/news', [PostController::class, 'store'])->name('news.store');

Route::post('/news/{post}/submit', [PostController::class, 'submit'])->name('news.submit');

Route::post('/news/{post}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');
Route::delete('/news/{post}/comments/{comment}', [CommentController::class, 'destroy'])
    ->middleware('auth')
    ->name('comments.destroy');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');
    Route::post('/moderation/{post}/approve', [ModerationController::class, 'approve'])->name('moderation.approve');
    Route::post('/moderation/{post}/reject', [ModerationController::class, 'reject'])->name('moderation.reject');

});