<?php

namespace App\Providers;

use App\Http\Controllers\GlobalAdminController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use View;

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
        //
        URL::forceRootUrl(config('app.url'));

        /**Declara o controlador global admin */
        $globalAdminController = new GlobalAdminController(); 

        /**Obtém os lembretes e notificações do GlobalController */
        $reminders = $globalAdminController->getReminders(); 
        $notifications = $globalAdminController->getNotifications(); 
        
        /**Compartilha os dados com todas as views */ 
        View::share('reminders', $reminders); 
        View::share('notifications', $notifications);
    }
}
