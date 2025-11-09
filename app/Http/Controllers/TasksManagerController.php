<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchTaskRequest;
use App\Http\Requests\TaskManagerRequest;
use App\Http\Requests\TaskManagerUpdateStatusRequest;
use App\Models\TasksManagerModel;
use App\Services\TaskManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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










    public function searchTasks( SearchTaskRequest $request ){


// $first_quary = "SELECT IF( TM.id > 0  , TM.id , T.id ) AS id ,T.title AS question , TP.title AS priority ,
//    TS.title   AS 'status' ,
//   IF(  TM.ID > 0 AND TM.status_id <> 3  , 'available' , 'blocked') AS availability FROM  tasks T

// JOIN  task_priority TP      ON TP.title      = 'low'
// JOIN  task_status   TS      ON TS.title      = 'in_progress'
// JOIN  task_manager TM       ON TM.task_id    = T.id  AND TM.user_id = 1 AND (  TM.status_id = TS.id  )
// WHERE T.task_priority = TP.id "


// $query = "SELECT IF(TM.id > 0  , TM.id , T.id ) AS id ,T.title AS question , TP.title AS priority ,
// IF( ( TM.status_id > 0 AND TS.id <> 3 ) , TS.title , 'pending' )  AS 'status' ,
// IF( OLD.id > 0 OR ( TM.ID > 0 AND TM.status_id <> 3 ) , 'available' , 'blocked') AS availability

// FROM `tasks` T JOIN task_priority     TP  ON TP.title    = 'low'
// LEFT JOIN task_status  TS  ON TS.title    = 'in_progress'
// LEFT JOIN task_manager TM  ON T.id        = TM.task_id AND TM.user_id = 1 AND TM.status_id = TS.id
// LEFT JOIN task_manager OLD ON OLD.task_id = ( TM.task_id - 1 ) AND OLD.status_id = 3
// WHERE task_priority = TP.id;"


             $validated_req = $request->validated();

              $status     = $validated_req['status']   ?? null ;
              $priority   = $validated_req['priority'] ?? null ;
              $user_id    = $validated_req['user_id']  ?? null ;



             $tasks_1 = DB::table('tasks as T')
                        ->select([
                            DB::raw('IF(TM.id > 0, TM.id, T.id) AS id'),
                            'T.title AS question',
                            'TP.title AS priority',
                            'TS.title AS status',
                            DB::raw("IF(TM.id > 0 AND TM.status_id <> 3, 'available', 'blocked') AS availability")
                        ])
                        ->join('task_priority as TP', function ($join) use ($priority) {
                            $join->on('T.task_priority', '=', 'TP.id')
                                ->where('TP.title', '=', $priority);
                        })
                        ->join('task_status as TS', function ($join) use ($status) {
                            $join->where('TS.title', '=', $status);
                        })
                        ->join('task_manager as TM', function ($join) use ($user_id) {
                            $join->on('TM.task_id', '=', 'T.id')
                                ->where('TM.user_id', '=', $user_id)
                                ->whereColumn('TM.status_id', 'TS.id');
                        })
                        ->get();

           if( !$tasks_1->isEmpty()){


             return  response()->json([
                    'success' => 'ok' ,
                    'message' => 'We successfully  got your tasks  !!! ' ,
                    'tasks'   => $tasks_1
                ]);



           }else{


               $tasks = DB::table('tasks as T')
                            ->select([
                                DB::raw('IF(TM.id > 0, TM.id, T.id) AS id'),
                                'T.title AS question',
                                'TP.title AS priority',
                                DB::raw("IF((TM.status_id > 0 AND TS.id <> 3), TS.title, 'pending') AS status"),
                                DB::raw("IF(OLD.id > 0 OR (TM.id > 0 AND TM.status_id <> 3), 'available', 'blocked') AS availability")
                            ])
                            ->join('task_priority as TP', function ($join) use ($priority) {
                                $join->on('T.task_priority', '=', 'TP.id')
                                    ->where('TP.title', '=', $priority);
                            })
                            ->leftJoin('task_status as TS', function ($join) use ($status) {
                                $join->where('TS.title', '=', $status);
                            })
                            ->leftJoin('task_manager as TM', function ($join) use ($user_id) {
                                $join->on('T.id', '=', 'TM.task_id')
                                    ->where('TM.user_id', '=', $user_id)
                                    ->whereColumn('TM.status_id', 'TS.id');
                            })
                            ->leftJoin('task_manager as OLD', function ($join) {
                                $join->on(DB::raw('OLD.task_id'), '=', DB::raw('(TM.task_id - 1)'))
                                    ->where('OLD.status_id', '=', 3);
                            })
                            ->whereColumn('T.task_priority', '=', 'TP.id')
                            ->get();





                if($tasks->isEmpty() )
                {
                    return response()->json([

                        'success' => false ,
                        'message' => 'not found  !!! we  was unable  to find  the tasks !!! ' ,
                        'error'  => 404
                    ] ) ;
                }

                return  response()->json([
                    'success' => 'ok' ,
                    'message' => 'We successfully  got your tasks  !!! ' ,
                    'tasks'   => $tasks
                ]);

         }

        }
}
