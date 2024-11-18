<?php

namespace App\Providers;

use Google\Client; 
use Google\Service\Calendar;
use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function ($app) { 
            $client = new Client(); 
            $client->setClientId(env('GOOGLE_CLIENT_ID')); 
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET')); 
            $client->setRedirectUri(env('GOOGLE_REDIRECT_URI')); 
            $client->addScope(Calendar::CALENDAR); 
            return $client; 
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
