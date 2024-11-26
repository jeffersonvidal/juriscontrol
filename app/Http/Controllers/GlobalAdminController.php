<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GlobalAdminController extends Controller
{
    /**Tudo que cadastrar aqui tem que adicionar no arquivo
     * app/Providers/AppServiceProvider.php
     */

     /**Retorna todos os usuários da empresa */
     public function getUsersByCompany(){
        // Obtenha o usuário logado 
        $user = Auth::user(); 
        // \Log::info('Usuário logado:', ['user' => $user ]);
        // Verifique se o usuário está autenticado 
        if ($user) { 
            // Obtenha todos os usuários com o mesmo company_id 
            $users = User::where('company_id', $user->company_id)->get(); 
        } else { 
            // Se não houver usuário logado, retorne uma coleção vazia 
            $users = collect(); 
        } 
        return $users;
     }

    /**Soma todos os lembretes da empresa e do usuário logado */
    function totalReminders()
    {
        $user = Auth::user();

        $totalReminders = Reminder::where(function($query) use ($user) {
                $query->where('company_id', $user->company_id)
                    ->orWhere('responsible_id', $user->id);
            })
            ->where('status', 'unread') // Adicionando a condição para status = 'unread'
            ->count();

        return $totalReminders;
    }

    /**Retorna todos os lembretes programados */
    public function getReminders() { 
        $user = Auth::user(); 
        $reminders = Reminder::where('company_id', $user->company_id)
        ->where('responsible_id', $user->id)
        ->where('status', 'unread')
        ->get();
        return $reminders; 
    } 

    /**Retorna todas as notificações do sistema */
    public function getNotifications() { 
        // Lógica para buscar as notificações 
        $notifications = ['Notificação 21', 'Notificação 2', 'Notificação 3']; 
        return $notifications; 
    }
}/**Fim classe GlobalAdminController */
