<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskManagerRequest;
use App\Http\Requests\TaskManagerUpdateStatusRequest;
use App\Services\TaskManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TasksManagerController extends Controller
{


    protected  TaskManagerService $service ;




    public function __construct(TaskManagerService $service ){

         $this->service = $service ;
    }

    public function create(TaskManagerRequest $request){

         $data = $request->validated();


         try{


        $response =  $this->service->createNewRow($request);

          if(!$response['success'] ){

            return response()->json([
               'success' => false ,
               'message' => 'failed to create new row' ,
               'response' => $response

            ] , 426 );
          }

          return response()->json([

            'success' => 'ok' ,
            'message'  => 'created new row ' ,
            'response'  => $response

          ] ) ;

         }catch(\Exception $e )
         {
             Log::error("Exception occurred while create new row in the task_manager" . $e->getMessage() . " at line " . $e->getLine() ) ;
            return response()->json([
            'success'  => false  ,
            'message'  => 'error occurred when creating task_manager row ' ,
            'error'    => $e->getMessage()

          ]);

         }
    }





    public function update( TaskManagerUpdateStatusRequest $request , $id ){


         $data = $request->validated();

         $request = $request->all() ;

         $status = $request['status'] ;

          $data = [

              'id'      => $id ,
              'status'  => $status

          ];

         $result =   $this->service->updateTaskManagerStatus($data) ;


         if(!$result['success'])
         {

            return response()->json([

                 'success'  => false ,
                 'message'  => 'failed to update status !!! ' ,
                 'data'     => $result

            ]) ;

         }


         return response()->json([

             'success' => 'ok' ,
             'message' => 'status has been updated !!!',
             'data'    => $result


         ], 200 );
    }




    public function getAvailableTasks($id){


        if(!$id)
        {
            return response()->json([

                  'success' => false ,
                  'message' => 'please , provide valid user_id ' ,

            ]);
        }

        try{

           $list =   $this->service->getNotCompletedTasks($id);

           if(!$list)
           {

               return response()->json([

                  'success' => 'ok' ,
                  'message' => 'we don\'t have any available tasks' ,
                  'list'    => $list

               ] , 404 );
           }

           return response()->json([

               'success' => 'ok' ,
               'message' => 'successfully got list of tasks' ,
               'list'    => $list

           ] , 200 );

        }catch(\Exception $e )
        {

            Log::error(' An exception occurred while getting the available list of tasks  ' . $e->getMessage() ) ;

            return response()->json([

                    'success'  => false ,
                    'message'  => 'Exception occurred while getting list of tasks ' ,
                    'error'    => $e->getMessage()
            ]);

        }






    }
}
