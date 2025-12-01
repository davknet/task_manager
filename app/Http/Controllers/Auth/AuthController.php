<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

     private AuthService $service ;


    public function __construct( AuthService $authService ){

          $this->service = $authService ;

    }

    public function register( RegisterRequest  $request ){




         try{


          $response  =  $this->service->Register($request);

          if( $response )
          {
               return response()->json([

                  'status'    => 'success' ,
                  'message'   => 'user has been created successfully '

               ], 200 );
          }

          return response()->json( [

              'status'   => ' Failure , something went wrong !!! ' ,
              'message'  => ' the user has not been created '      ,


          ] , 422 );

         }catch( Exception $e )
         {

              Log::error("Exception register" . $e->getMessage() );


              return response()->json([
                'status'  => 'error' ,
                'message' => 'error occurred !!! ' ,
                'code'    => 422
              ]);



         }



    }



   public function  login( LoginRequest $loginRequest ){

      // Wrong email or password. Please provide the correct details !!!

      $logged =  Auth::attempt( [
            'email'    => $loginRequest['email']  ,
            'password' => $loginRequest['password']
            ]);



         if( !$logged ){

             return response()->json([

                      'status'  => false ,
                      'message' => ' Wrong email or password. Please provide the correct details !!!' ,
             ]);
         }

            $owner    = Auth::user();
            $user_id  = $owner->id;



            $user = User::find( $user_id );
            $created_token = $user->createToken('access_token')->accessToken;








       return response()->json([

           'user'  =>   $user ,
           'token' =>  $created_token

       ]);



     }
}
