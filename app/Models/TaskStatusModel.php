<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskStatusModel extends Model
{
    //

    protected $table = ['ask_status'] ;

    protected $fillable = ['title' , 'description'] ;




    public function taskManager(){

        return $this->belongsTo(TasksManagerModel::class , 'status_id') ;
    }
}
