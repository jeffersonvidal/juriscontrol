<?php

namespace App\Providers;

use App\Http\Controllers\GlobalAdminController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use View;
use Illuminate\Support\Facades\Auth;
use App\Helpers\HelperAdm;

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

        View::composer('*', function ($view) { 
            if (Auth::check()){

                /**Declara o controlador global admin */
                $globalAdminController = new GlobalAdminController(); 
                
                /**Inclui arquivo helper */
                require_once app_path('Http/Helpers/HelpersAdm.php');

                /**Obtém os lembretes e notificações do GlobalController */
                $reminders = $globalAdminController->getReminders(); 
                $notifications = $globalAdminController->getNotifications(); 

                /**Retorna todos os usuários da empresa logada */
                $usersByCompany = $globalAdminController->getUsersByCompany();
                
                /**Compartilha os dados com todas as views */ 
                View::share('reminders', $reminders); 
                View::share('notifications', $notifications);
                View::share('usersByCompany', $usersByCompany);

            } /**Fim Auth::check */
        });
    }
}