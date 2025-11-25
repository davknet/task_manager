<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return [
                'name'       => 'required|string|min:3|max:50',
                'last_name'  => 'required|string|min:3|max:50',

                'email'      => 'required|email|unique:users,email',

                'password'   => [
                    'required',
                    'string',
                    'min:8',
                    'max:16',
                    'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/'
                ],
         ];

    }





    public function failedValidation(Validator $validator){


        throw new HttpResponseException(

               response()->json([

                  'success' => false ,
                  'message' =>  ' Please provide the correct credentials ' ,
                  'error'   => $validator->errors()
                ] , 422  )

               );




    }




}
