<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //


     public const ERROR_CODES = [

        'DEPENDENCY'   => 409,
        'BAD_REQUEST'  => 400,
        'NOT_FOUND'    => 404,
        'SERVER_ERROR' => 500,
        
    ];

    public const ERROR_MESSAGES = [

        'DEPENDENCY'   => "Circular dependency detected",
        'BAD_REQUEST'  => "Invalid request payload",
        'NOT_FOUND'    => "Resource not found",
        'SERVER_ERROR' => "Unexpected server error",

    ];



}
