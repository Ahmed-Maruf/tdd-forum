<?php


namespace App\Providers;


use App\Channel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(){

    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // Using Closure based composers...
        View::composer('*', function ($view) {
            //
            $view->with('channels', Channel::all());
        });
    }
}
