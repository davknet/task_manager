<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Dotenv\Parser\Parser as ParserParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Passport\Http\Middleware\CheckToken;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\Token;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Plain ;
use Workbench\App\Models\User as ModelsUser;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {



                try {
                $token = $request->bearerToken();
                $publicKeyPath  = storage_path('oauth-public.key');
                $privateKeyPath = storage_path('oauth-private.key');
                $publicKey      = InMemory::file($publicKeyPath );
                $privateKey     = InMemory::file($privateKeyPath);

                $config = Configuration::forAsymmetricSigner(
                new Sha256(),
                $privateKey ,
                $publicKey
                );


                $new_token = $config->parser()->parse($token);
                $tokenId = $new_token->claims()->get('jti');
                $userId  = $new_token->claims()->get('sub');


                $tokenModel = Token::find($tokenId);


                if(!$tokenModel || $tokenModel->revoked) {
                    return response()->json(
                        ['message' => 'Token invalid'], 401);
                }



            if($tokenModel->user_id != $request->user_id)
            {
              return response()->json(
                [
                'message' =>
                'Token does not belong to this user'],
                403
                );
             }




            }catch( \Throwable $e )
            {
                Log::error(' Invalid token ' . $e->getMessage() );
                return response()->json(['message' => 'Token corrupted'], 401);


            }

            return $next($request);

    }
}
