<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Google\Client; 
use Google\Service\Calendar; 
use Illuminate\Support\Facades\Session; 

class GoogleController extends Controller { 
    public function redirectToGoogle(Client $client) { 
        $authUrl = $client->createAuthUrl(); 
        return redirect()->away($authUrl); 
    } public function handleGoogleCallback(Request $request, Client $client) { 
        $client->authenticate($request->get('code')); 
        Session::put('google_token', $client->getAccessToken()); 
        return redirect()->route('events.index'); 
    } 



}