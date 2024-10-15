<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;


class BroadcastServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //Log::info('BroadcastServiceProvider boot method called.');

        // Authenticate the user's personal channel...
        Broadcast::routes();

        /*
         * Register any channel authorizations required by your application.
         * This is where you can define all your broadcast channels.
         */
        require base_path('routes/channels.php');
    }
}
