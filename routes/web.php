<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkEntryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('dashboard', function () {
    //     return Inertia::render('dashboard');
    // })->name('dashboard');

    Route::resource('missions', App\Http\Controllers\MissionController::class);

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('calendrier', [CalendarController::class, 'index'])->name('calendrier.index');
    Route::post('workEntry.save', [WorkEntryController::class, 'store'])->name('workEntry.save');
    Route::post('comment.save', [CommentController::class, 'store'])->name('comment.save');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
