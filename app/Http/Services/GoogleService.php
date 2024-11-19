<?php

namespace App\Http\Services;

use Google\Service\Oauth2;

class GoogleService
{
  protected $user;
  protected $client;

  public function __construct($user){
    $this->client = $this->googleClientConfig();
    $this->user = $user;
  }

  /**Configuração cliente google */
  private function googleClientConfig()
{
    $redirectURL = route('google.callback');
    $all_scopes = implode(' ', array(
        \Google_Service_Calendar::CALENDAR,
        Oauth2::USERINFO_PROFILE,
        Oauth2::USERINFO_EMAIL
    ));
    $client = new \Google_Client();
    $client->setApplicationName("Events");
    $client->setScopes($all_scopes);
    $client->setAuthConfig(storage_path('app/googleClient/client_secret.json'));
    $client->setState('gcalendar');
    $client->setRedirectUri($redirectURL);
    $client->setAccessType('offline');
    $client->setApprovalPrompt("force");
    return $client;
}

  /**url de autenticação */
  public function authUrl(){
    $client = $this->client;
    return $client->createAuthUrl();
  }


}/**fim class GoogleService */