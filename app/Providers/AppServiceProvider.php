<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Menu;
use App\Models\NewsItem;
use App\Models\Page;
use App\Models\Resource;
use App\Models\StaffProfile;
use App\Observers\AuditObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register audit observers for all content models
        Page::observe(AuditObserver::class);
        Book::observe(AuditObserver::class);
        NewsItem::observe(AuditObserver::class);
        StaffProfile::observe(AuditObserver::class);
        Menu::observe(AuditObserver::class);
        Resource::observe(AuditObserver::class);
    }
}
