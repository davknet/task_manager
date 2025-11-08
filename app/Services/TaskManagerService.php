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
                   ->leftJoin('users' , 'task_manager.user_id' , '=' , 'users.id')
                   ->leftJoin('tasks' , 'task_manager.task_id' , '=' , 'tasks.id' )
                   ->leftJoin('task_status' , 'task_manager.status_id' , '=' , 'task_status.id')
                   ->leftJoin('task_priority' , 'task_manager.priority_id' , '=' , 'task_priority.id')
                   ->leftJoin('task_answers' , 'task_manager.answer_id' , '=' , 'task_answers.id' )
                   ->where('task_manager.task_id' , $task_id )
                   ->where('task_manager.user_id' , $user_id )
                   ->select(
                    'task_manager.*' ,
                    'is_answer_correct.task_answers_id AS correct_answer_id' ,
                    'users.name as full_name' ,
                    'tasks.title as question' ,
                    'task_status.title as status' ,
                    'task_priority.title as priority' ,
                    'task_answers.answer_text as answer'

                   )
            ->latest('task_manager.id')
            ->first();



            $this->taskRepository->makeTestRecords($row);



            return response()->json([

                 'success' => 'ok' ,
                 'message' => 'the task created successfully ' ,
                 'data'    => $row

            ]);

    }
}
