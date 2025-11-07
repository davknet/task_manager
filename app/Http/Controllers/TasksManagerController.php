<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskManagerRequest;
use Illuminate\Http\Request;

class TasksManagerController extends Controller
{


    public function insertTask(TaskManagerRequest $request){



         dd($request);

    }
}
