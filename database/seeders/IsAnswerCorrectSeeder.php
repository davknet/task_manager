<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IsAnswerCorrectSeeder extends Seeder
{


    protected array $correct = [

          [ 'task_id' =>  1      ,  'task_answers_id' =>  1  ] ,
          [ 'task_id' =>  2      ,  'task_answers_id' =>  1  ] ,
          [ 'task_id' =>  3      ,  'task_answers_id' =>  3  ] ,


    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('is_answer_correct')->insert([



        ]);

        foreach($this->correct as $val )
        {
               DB::table('is_answer_correct')->insert([
                      'task_id'         => $val['task_id'] ,
                      'task_answers_id' => $val['task_answers_id'] ,
                      'created_at'      => now()

                 ]);

        }
    }
}
