<?php

namespace App\Providers;

use App\Models\UserFriend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.partials.sidebar', function ($view) {
            $count = 0;

            if(Auth::check()) {
                $count = UserFriend::where('friend_id', Auth::user()->id)
                                ->where('accepted', false)
                                ->count();
            }

            $view->with('friendRequestsCount', $count);
        });
    }
}
