<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{

     protected array $status = [

             [ 'title' =>  'pending' , 'description'     => ' pending  means no one touched to the task yet .  ' ]   ,
             [ 'title' =>  'in_progress' , 'description' =>  'in_progress the user started to  solve the task ' ] ,
             [ 'title' =>  'completed' , 'description'   => 'completed  the user finished    the task ' ] ,
     ] ;



    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        foreach( $this->status as  $val ){

             DB::table('task_status')->insert([
            'title'       =>  $val['title'] ,
            'description' =>  $val['description'] ,
            'created_at'  =>  now() ,
            'updated_at'  =>  null
        ]);


        }


    }
}
