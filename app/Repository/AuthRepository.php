<?php

namespace App\Repository;

use App\Models\User;

class AuthRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }




    public function registerNewUser($request){

           return    User::create($request) ;
    }
}
