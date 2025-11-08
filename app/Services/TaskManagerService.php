<?php

namespace App\Services;

use App\Models\TasksManagerModel;
use App\Models\TaskStatusModel;
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




           $row = $this->taskRepository->getTaskForRecord(  (int)$task_id , (int)$user_id );

           if( $row )
           {

           $res = $this->taskRepository->makeTestRecords($row);



           if(!$res['success'])
           {
               return [

                  'success' => false ,
                  'message' => 'tasks created successfully  but failed next task',
                  'data'    => $res

               ];
           }






            return [

                 'success' => 'ok' ,
                 'message' => 'the task created successfully' ,
                 'status'  =>   'completed' ,
                 'data'    =>  $res

            ] ;

           }


           return [

                 'success' => 'ok' ,
                 'message' => 'task created successfully !!!' ,
                 'data'    => $data

           ];

    }





    public function updateTaskManagerStatus(array $data ){

          $id      = $data['id'];
          $status  = $data['status'] ;

          $task_manager = TasksManagerModel::find($id);


         if(!$task_manager){

            return [
                'success' => false ,
                'message' => 'please, Provide correct valid id !!! '
            ];
         }elseif( $task_manager->status_id   ==  '3' )
        {

           return [

               'success' => false ,
               'message' => 'you can\'t update status of completed task'
           ];


        }



        $user_id    = $task_manager->user_id ;

        $new_status = DB::table('task_status')
                      ->where('title' , $status )
                      ->first();



        if( !$new_status )
         {

              return [
                    'success' => false,
                    'message' => ' status id is  not valid !!!  '
            ];

        }






       return  $this->taskRepository->updateStatus([
                'id'         => $id ,
                 'status_id' => $new_status->id  ,
                 'user_id'   => $user_id

                ]);

    }
}
