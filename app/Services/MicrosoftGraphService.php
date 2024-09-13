<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Token;
use Carbon\Carbon;

class MicrosoftGraphService
{

    protected $apiUrl = 'https://graph.microsoft.com/v1.0';

    public function sendMail($subject, $content, $recipient)
    {
        $accessToken = $this->refreshTokenIfNeeded(); // Refrescar token si es necesario
        
        $response = Http::withToken($accessToken)->post("{$this->apiUrl}/me/sendMail", [
            'message' => [
                'subject' => $subject,
                'body' => [
                    'contentType' => 'HTML',
                    'content' => $content,
                ],
                'toRecipients' => [
                    [
                        'emailAddress' => [
                            'address' => $recipient,
                        ],
                    ],
                ],
            ],
        ]);

        if ($response->successful()) {
            return ['status' => 'success', 'message' => 'Correo enviado con éxito'];
        } else {
            return ['status' => 'error', 'message' => $response->json()['error']['message']];
        }
    }

    public function refreshTokenIfNeeded()
    {
        $token = $this->getStoredToken();

        if ($this->hasTokenExpired($token)) {
            $tenantId = config('services.microsoft.tenant_id');
            $clientId = config('services.microsoft.client_id');
            $clientSec = config('services.microsoft.client_secret'); 
            $redirectUri = config('services.microsoft.redirect_uri');
            
            $response = Http::asForm()->post("https://login.microsoftonline.com/$tenantId/oauth2/v2.0/token", [
                'grant_type' => 'refresh_token',
                'client_id' => $clientId,
                'client_secret' =>$clientSec,
                'refresh_token' => $token->refresh_token,
                'redirect_uri' => $redirectUri
            ]);
            //=================================
            $body = $response->json();
            $newAccessToken = $body['access_token'];
            $newRefreshToken = $body['refresh_token'];
            $expiresAt = Carbon::now()->addSeconds($body['expires_in']);

            // Guarda los nuevos tokens en la base de datos
            $this->storeToken($newAccessToken, $newRefreshToken, $expiresAt);

            return $newAccessToken;
        }

        return $token->access_token;
    }

    protected function getStoredToken()
    {
        return Token::latest()->first(); // Recupera el token más reciente
    }

    protected function storeToken($accessToken, $refreshToken, $expiresAt)
    {
        Token::create([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_at' => $expiresAt,
        ]);
    }

    protected function hasTokenExpired($token)
    {
        return Carbon::now()->gte($token->expires_at); // Compara el tiempo actual con la expiración
    }
}
