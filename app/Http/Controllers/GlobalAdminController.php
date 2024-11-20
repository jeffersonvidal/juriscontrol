<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GlobalAdminController extends Controller
{
    /**Tudo que cadastrar aqui tem que adicionar no arquivo
     * app/Providers/AppServiceProvider.php
     */

    /**Retorna todos os lembretes programados */
    public function getReminders() { 
        // Lógica para buscar os lembretes 
        $reminders = ['Lembrete 1', 'Lembrete 2', 'Lembrete 3']; 
        return $reminders; 
    } 

    /**Retorna todas as notificações do sistema */
    public function getNotifications() { 
        // Lógica para buscar as notificações 
        $notifications = ['Notificação 1', 'Notificação 2', 'Notificação 3']; 
        return $notifications; 
    }
}/**Fim classe GlobalAdminController */
