<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SearchTaskRequest extends FormRequest
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

            'status'   =>  'nullable|string|in:pending,in_progress,completed' ,
            'priority' =>  'nullable|string|in:low,medium,high' ,
            'user_id'  =>  'required|exists:users,id'

        ];
    }



      protected function failedValidation(Validator $validator)
    {


       throw new HttpResponseException(
        response()->json([

            'success' => false ,
            'message' => 'validation failed , please provide status { pending , in_progress or completed } and priority { low, medium , high} and user_id "   ' ,
            'error'   => $validator->errors()

        ], 422 )

       );

    }
}
