<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AdminMovieController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Redirect root to movies
Route::get('/', function () {
    return redirect()->route('movies.index');
});

// Public movie routes
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Dashboard redirect to movies for authenticated users
Route::get('/dashboard', function () {
    return redirect()->route('movies.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rating routes (authenticated users only)
    Route::post('/movies/{movie}/rate', [RatingController::class, 'store'])->name('movies.rate');
    Route::delete('/movies/{movie}/rate', [RatingController::class, 'destroy'])->name('movies.rate.destroy');
    
    // Comment routes (authenticated users only)
    Route::post('/movies/{movie}/comments', [CommentController::class, 'store'])->name('movies.comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Movie management
    Route::resource('movies', AdminMovieController::class);
    
    // User management
    Route::resource('users', UserManagementController::class);
});

require __DIR__.'/auth.php';
