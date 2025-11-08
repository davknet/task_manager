<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskTestMakerModel extends Model
{

    protected $table = 'task_test_maker' ;

    protected $fillable = [
        'task_id '  ,
        'user_id'   ,
        'answer_id' ,
        'status_id' ,
        'priority_id'       ,
        'task_manager_id'   ,
        'full_name',
        'task' , 'status'   ,
        'priority'          ,
        'is_answer_correct' ,
        'created_at'        ,
        'updated_at'

     ] ;






     public function taskManager(){

        return $this->belongsTo(TasksManagerModel::class , 'task_manager_id') ;
    }


    public function tasks(){

        return $this->belongsTo(TasksModel::class , 'task_id' ) ;
    }



    public function answers(){

        return $this->belongsTo(TaskAnswers::class , 'answer_id') ;
    }


    public function status(){

       return $this->belongsTo( TaskStatusModel::class , 'status_id');
    }


    public function priority(){


       return  $this->belongsTo(TaskPriority::class , 'priority_id') ;
    }




    public function user(){

        return $this->belongsTo(User::class , 'user_id') ;
    }




    




}
