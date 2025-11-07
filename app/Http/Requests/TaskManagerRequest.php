<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class TaskManagerRequest extends FormRequest
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
            'task_id'     => 'required|exists:tasks,id' ,
            'priority_id' => 'required|exists:task_priority,id',
            'status_id'   => 'required|exists:task_status,id' ,
            'answer_id'   => 'required|exists:task_answers,id' ,
            'user_id'     => 'required|exists:users,id'
        ];
    }


    protected function withValidator(Validator $validator ){


        $validator->after(function ($validator ) {

             $this->makeDbValidation($validator);


        });


    }

    protected function makeDbValidation(Validator $validator){


           $priority_id = $this->input('priority_id') ;
           $task_id     = $this->input('task_id');
           $answer_id   = $this->input('task_id');
           $status_id   = $this->input('status_id');
           $user_id     = $this->input('user_id') ;



           if( $priority_id > 1 ){

               $low_priority = $priority_id - 1 ;

                $valid = DB::table('task_manager')
                ->where( 'priority_id' , $low_priority )
                ->where('user_id' , $user_id)
                ->where('task_id' , $task_id )
                ->exists();

                if(!$valid ){

                    $validator->errors()->add('priority_id' , 'you mast to the lower priority task at first');
                }

           }




    }


}
