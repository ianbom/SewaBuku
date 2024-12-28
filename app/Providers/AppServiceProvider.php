<?php

namespace App\Providers;

use App\Http\View\Composers\SidebarChapter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('sewa_buku.layouts.sidebar_chapter', SidebarChapter::class);
    }
}
