<?php

namespace App\Repository;

use App\Models\TaskTestMakerModel;

class TaskRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    public function makeTestRecords($data){


        $task_id           = $data->task_id ;
        $user_id           = $data->user_id ;
        $answer_id         = $data->answer_id ;
        $status_id         = $data->status_id ;
        $priority_id       = $data->priority_id ;
        $task_manager_id   = $data->task_manager_id ;
        $full_name         = $data->full_name ;
        $task              = $data->question  ;
        $status            = $data->status    ;
        $priority          = $data->priority  ;
        $correct_answer_id = $data->correct_answer_id ;
        $is_answer_correct = ( $answer_id ==  $correct_answer_id ) ? true : false ;
        $created_at        = $data->created_at  ;
        $updated_at        = $data->updated_at  ;
        $answer            = $data->answer      ;






        TaskTestMakerModel::create([

               'task_id'     => $task_id ,
               'user_id'     => $user_id ,
               'answer_id'   => $answer_id  ,
               'status_id'   => $status_id  ,
               'priority_id' => $priority_id ,
               'task_manager_id' => $task_manager_id,
               'full_name'   =>  $full_name ,
               'task'        =>  $task  ,
               'status'      =>  $status ,
               'priority'    =>  $priority,
               'correct_answer_id' =>  $correct_answer_id ,
               'is_answer_correct' => $is_answer_correct  ,
               'created_at'        => $created_at ,
               'updated_at'        => $updated_at ,
               'answer'            => $answer

        ]) ;



    }

}
