<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasksModel extends Model
{

     protected $table = 'tasks' ;


     protected $fillable = [ 'task_priority' , 'title' , 'description'] ;






     public function priority(){

         $this->belongsTo(TaskPriority::class  , 'task_priority') ;

     }



}
