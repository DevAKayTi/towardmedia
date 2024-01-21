<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
//        if (App::environment('production', 'local', 'development')) {
//            URL::forceScheme('https');
//        }
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        if (!app()->runningInConsole()) {
            View::share('allPosts', Post::query()->count());
            View::share('publishedPosts', Post::query()->where('published_at', '!=', null)->count());
            View::share('unpublishedPosts', Post::query()->where('published_at', null)->count());
        }

        Paginator::useBootstrap();
    }
}
