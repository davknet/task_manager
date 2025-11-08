<?php

namespace App\Repository;

use App\Models\TasksManagerModel;
use App\Models\TasksModel;
use App\Models\TaskTestMakerModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function makeTestRecords($data){


        $task_id           = $data->task_id ;
        $user_id           = $data->user_id ;
        $answer_id         = $data->answer_id ;
        $status_id         = $data->status_id ;
        $priority_id       = $data->priority_id ;
        $task_manager_id   = $data->task_manager_id ;
        $full_name         = $data->full_name ;
        $task              = $data->question  ;
        $status            = $data->status    ;
        $priority          = $data->priority  ;
        $correct_answer_id = $data->correct_answer_id ;
        $is_answer_correct = ( $answer_id ==  $correct_answer_id ) ? true : false ;
        $created_at        = $data->created_at  ;
        $updated_at        = $data->updated_at  ;
        $answer            = $data->answer      ;





            $result = DB::table('task_test_maker')->insert([
                    'task_id'    => $task_id ,
                    'user_id'     => $user_id ,
                    'answer_id'   => $answer_id  ,
                    'status_id'   => $status_id  ,
                    'priority_id' => $priority_id ,
                    'task_manager_id' => $task_manager_id,
                    'full_name'   =>  $full_name ,
                    'task'        =>  $task  ,
                    'status'      =>  $status ,
                    'priority'    =>  $priority,
                    'is_answer_correct' => $is_answer_correct  ,
                    'created_at'        => $created_at ,
                    'updated_at'        => $updated_at ,
                    'answer'            => $answer
                ]);



                if(!$result ){

                    return [

                        'success' => false ,
                        'message' => 'failed to create row in the task_manager_test ' ,
                        'result'  => $result

                    ];
                }



                $next =  $this->getNextTask($task_id);

                if(!$next){

                    return [
                              'success' => false ,
                              'message' => 'failed to get $next task' ,
                              'data'    => $next
                    ] ;
                }

                return [

                    'success' => 'ok' ,
                    'message' => 'get next task  data ' ,
                    'data'    =>  $next

                    ] ;
    }


    public function getNextTask( int $task_id  ){

           $next_task_id = $task_id + 1 ?? 0 ;
           $result       = TasksModel::with('priority' , 'answers' )
                           ->where('tasks.id' , $next_task_id )
                           ->first();
      return $result ;
    }



    public function updateStatus(array $data  ){

        $task_manager_id   =  (int) $data['id'] ;
        $status_id         =  $data['status_id'] ;

      $result =  TasksManagerModel::where('id' ,   $task_manager_id   )
                            ->where('status_id' , '!=' , '3' )
                            ->update(['status_id' => $status_id  , 'updated_at' => now() ] );

      if(!$result)
      {
          return [
            'success' => 'ok' ,
            'message' =>  ' failed to update task status!!! ' ,
            'result'  => $result
          ];
      }


      $user_id = (int)$data['user_id'];


      $row     = $this->getTaskForRecordByTaskManagerId( $task_manager_id , $user_id   ) ;


      if($row){

       $res = $this->makeTestRecords($row);


       if(!$res['success'])
       {


                return [
                        'success' => 'ok' ,
                        'message' =>  'task status has been updated !!! ' ,
                        'result'  => $result
                ];
       }



                return [

                            'success' => 'ok' ,
                            'message' => 'the task created successfully' ,
                            'status'  =>   'completed' ,
                            'data'    =>  $res

                        ];

      }


       return [
            'success' => 'ok' ,
            'message' =>  'task status has been updated !!! ' ,
            'result'  => $result
       ];


    }





    public function getTaskForRecord( int $task_id , int $user_id ){

        Log::info("message task_id $task_id user id $user_id ");

        $row = DB::table('task_manager')
                   ->leftJoin( 'is_answer_correct', 'task_manager.task_id', '=', 'is_answer_correct.task_id' )
                   ->leftJoin('users' , 'task_manager.user_id' , '=' , 'users.id')
                   ->leftJoin('tasks' , 'task_manager.task_id' , '=' , 'tasks.id' )
                   ->leftJoin('task_status' , 'task_manager.status_id' , '=' , 'task_status.id')
                   ->leftJoin('task_priority' , 'task_manager.priority_id' , '=' , 'task_priority.id')
                   ->leftJoin('task_answers' , 'task_manager.answer_id' , '=' , 'task_answers.id' )
                   ->where('task_manager.task_id' , $task_id )
                   ->where('task_manager.user_id' , $user_id )
                   ->where('task_manager.status_id',  3 )
                   ->select(
                    'task_manager.*' ,
                    'is_answer_correct.task_answers_id AS correct_answer_id' ,
                    'users.name as full_name' ,
                    'tasks.title as question' ,
                    'task_manager.id AS task_manager_id',
                    'task_status.title as status' ,
                    'task_priority.title as priority' ,
                    'task_answers.answer_text as answer'

                   )
            ->latest('task_manager.id')
            ->first();

            return $row ;

    }


      public function getTaskForRecordByTaskManagerId( int $task__manager_id , int $user_id ){



        $row = DB::table('task_manager')
                   ->leftJoin( 'is_answer_correct', 'task_manager.task_id', '=', 'is_answer_correct.task_id' )
                   ->leftJoin('users' , 'task_manager.user_id' , '=' , 'users.id')
                   ->leftJoin('tasks' , 'task_manager.task_id' , '=' , 'tasks.id' )
                   ->leftJoin('task_status' , 'task_manager.status_id' , '=' , 'task_status.id')
                   ->leftJoin('task_priority' , 'task_manager.priority_id' , '=' , 'task_priority.id')
                   ->leftJoin('task_answers' , 'task_manager.answer_id' , '=' , 'task_answers.id' )
                   ->where('task_manager.id' , $task__manager_id )
                   ->where('task_manager.user_id' , $user_id )
                   ->where('task_manager.status_id',  3 )
                   ->select(
                    'task_manager.*' ,
                    'is_answer_correct.task_answers_id AS correct_answer_id' ,
                    'users.name as full_name' ,
                    'tasks.title as question' ,
                    'task_manager.id AS task_manager_id',
                    'task_status.title as status' ,
                    'task_priority.title as priority' ,
                    'task_answers.answer_text as answer'

                   )
            ->latest('task_manager.id')
            ->first();

            return $row ;

    }

}
