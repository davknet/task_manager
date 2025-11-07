<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasksModel extends Model
{

     protected $table = 'tasks' ;


     protected $fillable = [ 'task_priority' , 'title' , 'description'] ;






     public function priority(){

        return  $this->belongsTo(TaskPriority::class  , 'task_priority') ;

     }

      public function answers(){

       return   $this->hasMany(TaskAnswers::class , 'task_id') ;

     }



}
