<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MicrosoftGraphService;
use Illuminate\Support\Facades\Http; 
use App\Models\Token;
use Carbon\Carbon;

class MailController extends Controller
{
    protected $graphService;

    public function __construct(MicrosoftGraphService $graphService)
    {
        $this->graphService = $graphService;
    }

    public function redirectToMicrosoft()
    {
        $tenantId = config('services.microsoft.tenant_id');
        $clientId = config('services.microsoft.client_id');
        $redirectUri = config('services.microsoft.redirect_uri');
        $scope = 'Mail.ReadWrite';

        $authorizationUrl = "https://login.microsoftonline.com/$tenantId/oauth2/v2.0/authorize?" . http_build_query([
            'client_id' => $clientId,
            'response_type' => 'code',
            'redirect_uri' => $redirectUri,
            'response_mode' => 'query',
            'scope' => $scope,
            'state' => 'some_random_state', // Usa un valor adecuado para proteger contra CSRF
        ]);
        return redirect($authorizationUrl);
    }

    public function handleMicrosoftCallback(Request $request)
    {
        $code = $request->query('code');
        $tenantId = config('services.microsoft.tenant_id');
        $clientId = config('services.microsoft.client_id');
        $clientSecret = config('services.microsoft.client_secret');
        $redirectUri = config('services.microsoft.redirect_uri');

        $response = Http::asForm()->post("https://login.microsoftonline.com/$tenantId/oauth2/v2.0/token", [
            'grant_type' => 'authorization_code',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'code' => $code,
            'scope' => 'Mail.ReadWrite Mail.Send User.Read profile openid email offline_access',
        ]);
       
        $body = $response->json();
        $accessToken = $body['access_token'];
        $newRefreshToken = $body['refresh_token'];
        $expiresAt = Carbon::now()->addSeconds($body['expires_in']);
        // Guarda el token de acceso en la sesión
        //session(['access_token' => $accessToken]);
        
        Token::create([
            'access_token' => $accessToken,
            'refresh_token' => $newRefreshToken,
            'expires_at' => $expiresAt,
        ]);

        return redirect('/send-mail');
    }

    public function sendMail(Request $request)
    {

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'recipient' => 'required|email',
        ]);
    
        // Depura los datos validados
        \Log::info('Validated Data:', $validated);
    
        $ultimoToken = Token::latest()->first(); //token desde la base de datos
        $accessToken = $ultimoToken->access_token; //recuperar token
        //return $accessToken;
        if (!$accessToken) {
            //refrescar token

            return response()->json(['error' => 'Access token is missing'], 400);
        }
        
        // Renderiza la vista Blade con el contenido HTML
        $content = view('correos.email', [
            'detalle' => 'Felicidades, ganaste una recompensa de Evolución', // valores para la vista de correo
            'puntos' => '24',
        ])->render();

        // enviar correo
        $result = $this->graphService->sendMail(
            $validated['subject'],
            $content,
            $validated['recipient']
        );
        if ($result['status'] === 'success') {
            return response()->json(['message' => $result['message']], 200);
        } else {
            return response()->json(['error' => $result['message']], 500);
        }
    }
    
}
