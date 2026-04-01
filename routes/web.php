<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ModerationController;
    use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/news', [PostController::class, 'newsPage']);

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');
    
    Route::post('/moderation/{post}/approve', [ModerationController::class, 'approve'])->name('moderation.approve');
    Route::post('/moderation/{post}/reject', [ModerationController::class, 'reject'])->name('moderation.reject');

});