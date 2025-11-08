<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_test_maker', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id'  );
            $table->unsignedBigInteger('user_id'  );
            $table->unsignedBigInteger('answer_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('priority_id');
            $table->unsignedBigInteger('task_manager_id');
            $table->string('full_name');
            $table->string('task' ,  255 );
            $table->string('status');
            $table->string('priority');
            $table->string('answer') ;
            $table->boolean('is_answer_correct');
            $table->timestamps();


            $table->foreign('task_id')
                    ->references('id')
                    ->on('tasks')
                    ->onDelete('cascade');

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('answer_id')
                    ->references('id')
                    ->on('task_answers')
                    ->onDelete('cascade');


            $table->foreign('status_id')
                    ->references('id')
                    ->on('task_status')
                    ->onDelete('cascade');


            $table->foreign('priority_id')
                    ->references('id')
                    ->on('task_priority')
                    ->onDelete('cascade');


            $table->foreign('task_manager_id')
                     ->references('id')
                     ->on('task_manager')
                     ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_test_maker');
    }
};
