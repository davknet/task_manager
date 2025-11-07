<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskPriority extends Model
{
     use HasFactory;
    protected $table = 'task_priority' ;

    protected $fillable = [ 'title' , 'description' ] ;




     public function tasks(){

       return   $this->hasMany( TasksModel::class , 'task_priority' ) ;

     }



     public function answers(){

        $this->hasMany(TaskAnswers::class , 'task_id') ;

     }


}
