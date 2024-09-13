<?php
namespace App\Services;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class OAuthService
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new GenericProvider([
            'clientId'                => env('MAIL_CLIENT_ID'),
            'clientSecret'            => env('MAIL_CLIENT_SECRET'),
            'redirectUri'             => env('MAIL_REDIRECT_URI'), // Puedes configurarlo en tu .env
            'urlAuthorize'            => 'https://login.microsoftonline.com/{tenant}/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/{tenant}/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => '',
            'scopes'                  => 'https://outlook.office.com/.default'
        ]);
    }

    public function getAccessToken()
    {
        try {
            // Obtiene el access token
            $accessToken = $this->provider->getAccessToken('client_credentials');
            return $accessToken->getToken();
        } catch (IdentityProviderException $e) {
            // Manejo de errores
            throw new \Exception($e->getMessage());
        }
    }

    public function refreshToken($refreshToken)
    {
        try {
            // Refresca el token de acceso
            $newAccessToken = $this->provider->getAccessToken('refresh_token', [
                'refresh_token' => $refreshToken
            ]);
            return $newAccessToken->getToken();
        } catch (IdentityProviderException $e) {
            // Manejo de errores
            throw new \Exception($e->getMessage());
        }
    }
}
