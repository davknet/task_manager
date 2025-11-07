<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAnswers extends Model
{
    //

    protected $table    = 'task_answers' ;

    protected $fillable = [ 'task_id' , 'answer_text' ] ;



    public function tasks(){


        return $this->belongsTo(TasksModel::class , 'task_id' ) ;
    }


}
