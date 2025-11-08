<?php

namespace App\Services;

use App\Models\TasksManagerModel;
use App\Repository\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskManagerService
{


    public TaskRepository $taskRepository ;
    /**
     * Create a new class instance.
     */
    public function __construct( TaskRepository $taskRepository )
    {
        $this->taskRepository = $taskRepository;
    }




    public function createNewRow( $request){


           $data  =  $request->all();

           $user_id     = $data['user_id'];
           $time        = $data['s_time'] ?? now()->toDateTimeString();
           $task_id     = $data['task_id'];
           $priority_id = $data['priority_id'];
           $status_id   = $data['status_id'] ;
           $answer_id   = $data['answer_id'] ;







      $created =   TasksManagerModel::create([

                's_time'      => $time        ,
                'user_id'     => $user_id     ,
                'task_id'     => $task_id     ,
                'priority_id' => $priority_id ,
                'status_id'   => $status_id   ,
                'answer_id'   => $answer_id   ,
                'created_at'  => now() ,
                'updated_at'  => null

         ]);






            $last_id  = $created->id ?? null ;


            if(is_null($last_id))
            {
                return response()->json([

                    'success'  => false ,
                    'message'  => 'failed to create task\'s manager row ' ,
                    'response' =>  $created


                ]);
            }



            $row = DB::table('task_manager')
                   ->leftJoin( 'is_answer_correct', 'task_manager.task_id', '=', 'is_answer_correct.task_id' )
                   ->where('task_manager.task_id' , $task_id )
                   ->where('task_manager.user_id' , $user_id )
                   ->select(
                    'task_manager.*' ,
                    'is_answer_correct.task_answers_id AS correct_answer_id'
                   )
            ->latest('task_manager.id')
            ->first();



            return response()->json([

                 'success' => 'ok' ,
                 'message' => 'the task created successfully ' ,
                 'data'    => $row

            ]);

    }
}
