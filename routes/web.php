<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AdminMovieController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Landing page route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public movie routes
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Dashboard redirect to home for authenticated users
Route::get('/dashboard', function () {
    return redirect()->route('home');
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
    
    // Watchlist routes (authenticated users only)
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::post('/movies/{movie}/watchlist', [WatchlistController::class, 'toggle'])->name('movies.watchlist.toggle');
    Route::post('/movies/{movie}/watchlist/add', [WatchlistController::class, 'add'])->name('movies.watchlist.add');
    Route::delete('/movies/{movie}/watchlist', [WatchlistController::class, 'remove'])->name('movies.watchlist.remove');
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
    Route::get('/users/{user}/watchlist', [UserManagementController::class, 'watchlist'])->name('users.watchlist');
    
    // Watchlist management (simplified - only by user)
    Route::get('/watchlists', [App\Http\Controllers\Admin\WatchlistManagementController::class, 'byUser'])->name('watchlists.index');
    Route::delete('/watchlists/remove', [App\Http\Controllers\Admin\WatchlistManagementController::class, 'removeItem'])->name('watchlists.remove');
});

require __DIR__.'/auth.php';

// Debug routes (only in development)
if (app()->environment('local')) {
    require __DIR__.'/debug.php';
}
