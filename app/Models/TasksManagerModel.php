<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasksManagerModel extends Model
{
     protected $table = 'task_manager' ;

     protected $fillable = [ 's_time' , 'user_id' , 'task_id' , 'priority_id' , 'status_id'  , 'answer_id' ,'created_at' , 'updated_at'  ] ;





     public function answers(){

        return $this->hasMany(TaskAnswers::class , 'answer_id') ;
     }



     public function status(){

       return  $this->hasMany(TaskStatusModel::class , 'status_id') ;
     }


     public function priority(){

       return  $this->hasMany(TaskPriority::class , 'priority_id') ;

     }


     public function tasks(){

          return $this->hasMany(TasksModel::class , 'task_id') ;
     }

}
