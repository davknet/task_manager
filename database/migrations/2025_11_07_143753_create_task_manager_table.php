<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_manager', function (Blueprint $table) {
            $table->id();
            $table->timestamp('s_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('priority_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('answer_id');
            $table->timestamps();


             $table->foreign('task_id')
                  ->references('id')
                  ->on('tasks')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('priority_id')
                  ->references('id')
                  ->on('task_priority')
                  ->onDelete('cascade');

            $table->foreign('status_id')
                  ->references('id')
                  ->on('task_status')
                  ->onDelete('cascade');

            $table->foreign('answer_id')
                  ->references('id')
                  ->on('task_answers')
                  ->onDelete('cascade');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_manager');
    }
};
