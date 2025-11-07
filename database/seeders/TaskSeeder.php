<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{

    protected array $tasks = [
         [ 'title' => "A car moves at a constant speed of 20 m/s. How far does it travel in 10 seconds?" , "description" => "" ] ,
         [ 'title' => "If the same car starts from rest and accelerates uniformly to 20 m/s in 10 seconds, what is its acceleration?" , "description" => "" ] ,
         [ 'title' => "With the acceleration from Task B, what distance does the car cover in the first 10 seconds?" , "description" => "" ] ,
    ] ;



    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        foreach($this->tasks as $key =>  $val )
        {
              $key = $key + 1 ;

               DB::table('tasks')->insert([

                    "task_priority" => $key ,
                    "title"         => $val['title'] ,
                    "description"   => $val['description'],
                    "created_at"    => now() ,
                    "updated_at"    => null

                ]);



        }


    }
}
