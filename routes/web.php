<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'librarian') {
            return redirect()->route('librarian.dashboard');
        } elseif ($user->role === 'staff') {
            return redirect()->route('staff.dashboard');
        }

        // Member Dashboard logic
        $activeBorrowings = \App\Models\Borrowing::with('book')
            ->where('user_id', $user->id)
            ->where('status', 'borrowed')
            ->latest()
            ->get();

        $recentBooks = \App\Models\Book::where('status', 'available')
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard', compact('activeBorrowings', 'recentBooks'));
    })->name('dashboard');

    // Standard Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Member Borrowing Routes (all authenticated users)
    Route::get('/my-borrowings', [\App\Http\Controllers\BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/borrow/{book}', [\App\Http\Controllers\BorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('/borrow', [\App\Http\Controllers\BorrowingController::class, 'store'])->name('borrowings.store');
    Route::patch('/borrowings/{borrowing}/return', [\App\Http\Controllers\BorrowingController::class, 'return'])->name('borrowings.return');

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
        Route::resource('news', \App\Http\Controllers\NewsController::class)->except(['show']); // Index now allowed for admin list
        Route::resource('books', \App\Http\Controllers\BookController::class)->except(['show']);
        Route::get('/site-content', [\App\Http\Controllers\SiteContentController::class, 'index'])->name('site-content.index');
        Route::post('/site-content', [\App\Http\Controllers\SiteContentController::class, 'store'])->name('site-content.store');
        Route::post('/books/reorder', [\App\Http\Controllers\BookController::class, 'reorder'])->name('books.reorder');
        Route::post('/news/reorder', [\App\Http\Controllers\NewsController::class, 'reorder'])->name('news.reorder');

        // Borrowing Management for Staff/Librarian
        Route::get('/borrowings', [\App\Http\Controllers\BorrowingController::class, 'manage'])->name('borrowings.index');
    });

    // Librarian Only Management
    Route::middleware(['role:librarian'])->prefix('staff')->name('staff.')->group(function () {
        Route::resource('staff-profiles', \App\Http\Controllers\StaffProfileController::class)->except(['show']);
        Route::post('/staff-profiles/reorder', [\App\Http\Controllers\StaffProfileController::class, 'reorder'])->name('staff-profiles.reorder');

        // Menu Management Routes
        Route::resource('menus', \App\Http\Controllers\MenuController::class)->except(['show']);
        Route::post('/menus/reorder', [\App\Http\Controllers\MenuController::class, 'reorder'])->name('menus.reorder');
        Route::patch('/menus/{menu}/toggle-visibility', [\App\Http\Controllers\MenuController::class, 'toggleVisibility'])->name('menus.toggle-visibility');

        // Page Management Routes
        Route::resource('pages', \App\Http\Controllers\PageController::class)->except(['show']);
        Route::post('/pages/reorder', [\App\Http\Controllers\PageController::class, 'reorder'])->name('pages.reorder');
        Route::post('/pages/{page}/update-content', [\App\Http\Controllers\PageController::class, 'updateContent'])->name('pages.update-content');
        Route::get('/pages/{page}/preview', [\App\Http\Controllers\PageController::class, 'preview'])->name('pages.preview');
        Route::post('/pages/upload-image', [\App\Http\Controllers\PageController::class, 'uploadImage'])->name('pages.upload-image');

        // Resource Management Routes
        Route::resource('resources', \App\Http\Controllers\ResourceController::class)->except(['show']);
        Route::post('/resources/reorder', [\App\Http\Controllers\ResourceController::class, 'reorder'])->name('resources.reorder');
    });
});


Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/pages/{page}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');
Route::get('/books/{book}', [\App\Http\Controllers\BookController::class, 'show'])->name('books.show');
Route::get('/news/{news}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

require __DIR__ . '/auth.php';
