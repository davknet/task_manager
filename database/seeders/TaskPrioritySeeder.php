<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskPrioritySeeder extends Seeder
{

    protected array $priority = [

         [ "title" => "low"    , "description" => "The low priority of the task by our logic, must be done last " ],
         [ "title" => "medium" , "description" => "The medium priority of the task, by our logic, must be done before the last  task " ],
         [ "title" => "high"   , "description" => "The high priority of the task, by our logic, must be done first" ],




    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

             foreach( $this->priority as  $val ){

                    DB::table('task_priority')->insert([
                        'title'       =>  $val['title'] ,
                        'description' =>  $val['description'] ,
                        'created_at'  =>  now() ,
                        'updated_at'  =>  null
                ]);
             }
   }
}
