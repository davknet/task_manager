<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskAnswersSeeder extends Seeder
{


     protected array $answers = [

        [  '200m'   , '2m'     , '50m'        , '1000m' ] ,
        [  '2m/s²'  , '10m/s²' ,  '0.5m/s²'   , '20m/s²'] ,
        [  '100m'   , '50m'    , '100m'                 ]


     ];



    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $tasks = DB::table('tasks')->get();



        foreach($tasks as $key => $task )
        {

              if(!isset($this->answers[$key]) )
              {
                 return ;
              }

              foreach( $this->answers[$key] as $val  )
              {
                DB::table('task_answers')->insert([

                      "task_id"      => $task->id ,
                      "answer_text"  => $val,
                      'created_at'   => now()


                ]);
              }
        }


    }
}
