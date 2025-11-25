<?php

namespace App\Services;

use App\Repository\AuthRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{


    protected AuthRepository $auth_repository ;

    /**
     * Create a new class instance.
     */
    public function __construct(AuthRepository $auth_repository)
    {

        $this->auth_repository = $auth_repository ;

    }




         public function Register($request){
        {


             $request = $request->all();

             $request['password'] = Hash::make($request['password']);


             $this->auth_repository->registerNewUser($request);


        }


    }
}
