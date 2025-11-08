<?php

namespace App\Http\Controllers;

use App\Models\TasksModel;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //


    function index(){

       $tasks =  TasksModel::with([ 'priority', 'answers'])->get();
       return response()->json($tasks) ;

    }

}
