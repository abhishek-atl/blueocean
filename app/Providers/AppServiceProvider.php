<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use App\Services\FormSpamProtection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
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
        foreach (['join-us', 'gifts'] as $form) {
            RateLimiter::for($form, fn (Request $request) => app(FormSpamProtection::class)->limit($request));
        }

        Paginator::useBootstrapFive();
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });
    }
}
