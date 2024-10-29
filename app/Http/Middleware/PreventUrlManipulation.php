<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class PreventUrlManipulation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log da URL recebida para debugging 
        Log::info('URL recebida: ' . $request->url()); 
        // Adicione lógica aqui para verificar e corrigir a URL se necessário 
        $url = $request->url(); 
        if (strpos($url, 'id') !== false && strpos($url, 'vidal') !== false) { 
            // Lógica para corrigir a URL 
            $correctedUrl = str_replace('id', 'vidal', $url); 
            Log::info('URL corrigida: ' . $correctedUrl); 
            return redirect($correctedUrl); 
        } 
        return $next($request); 
    }
}
