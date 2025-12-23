<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'librarian') {
            return redirect()->route('librarian.dashboard');
        } elseif ($user->role === 'staff') {
            return redirect()->route('staff.dashboard');
        }
        return redirect()->route('home'); // Redirect normal users to landing page
    })->name('dashboard');

    // Standard Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Librarian Routes
    Route::middleware(['role:librarian'])->prefix('librarian')->name('librarian.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Librarian\DashboardController::class, 'index'])->name('dashboard');
        Route::patch('/users/{user}/role', [\App\Http\Controllers\Librarian\DashboardController::class, 'updateRole'])->name('users.update-role');
        Route::delete('/users/{user}', [\App\Http\Controllers\Librarian\DashboardController::class, 'destroy'])->name('users.destroy');
    });

    // Staff & Librarian Management Routes
    Route::middleware(['role:staff,librarian'])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard');

        // Resource Controllers for CMS
        Route::resource('news', \App\Http\Controllers\NewsController::class)->except(['index', 'show']); // Index/Show are on landing page
        Route::resource('staff-profiles', \App\Http\Controllers\StaffProfileController::class)->except(['index', 'show']);
        Route::resource('books', \App\Http\Controllers\BookController::class)->except(['index', 'show']);
        Route::get('/site-content', [\App\Http\Controllers\SiteContentController::class, 'index'])->name('site-content.index');
        Route::post('/site-content', [\App\Http\Controllers\SiteContentController::class, 'store'])->name('site-content.store');
        Route::post('/staff-profiles/reorder', [\App\Http\Controllers\StaffProfileController::class, 'reorder'])->name('staff-profiles.reorder');
        Route::post('/books/reorder', [\App\Http\Controllers\BookController::class, 'reorder'])->name('books.reorder');
        Route::post('/news/reorder', [\App\Http\Controllers\NewsController::class, 'reorder'])->name('news.reorder');
    });
});


Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

require __DIR__ . '/auth.php';
