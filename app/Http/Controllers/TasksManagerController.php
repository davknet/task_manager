<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskManagerRequest;
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

          if(!$response){

            return response()->json([
               'success' => false ,
               'message' => 'failed to create new row' ,
               'response' => $response

            ]);
          }

          return response()->json([

            'success' => 'ok' ,
            'message'  => 'created new row ' ,
            'response'  => $response

          ] ) ;

         }catch(\Exception $e )
         {
             Log::error("Exception occurred while create new row in the task_manager" .$e->getMessage() . " at line " . $e->getLine() ) ;

         }



        //  return response()->json(['status' => 'ok']  , 200 );




    }
}
