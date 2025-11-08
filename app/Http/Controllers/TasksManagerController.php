<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskManagerRequest;
use Illuminate\Http\Request;

class TasksManagerController extends Controller
{


    public function create(TaskManagerRequest $request){

         $data = $request->validated();


         

         return response()->json(['status' => 'ok']  , 200 );




    }
}
