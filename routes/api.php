<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TasksManagerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');






Route::prefix('auth')->name('auth.')->group(function (){

    Route::post('/register' , [ AuthController::class, 'register'])->name('register');
    Route::post('/login'    , [ AuthController::class , 'login' ] )->name('login');



});





Route::prefix('tasks')->controller(TaskController::class)->group(function () {
    Route::get('/', 'index')->name('tasks');
});



Route::prefix('/make/manager')->name('make.manager.')
->middleware('ensure_token')
->group(function () {


    Route::post('/create', [TasksManagerController::class, 'create'])->name('create');
    Route::patch('/update/{id}/status', [TasksManagerController::class, 'update'])->name('update');
    Route::get('/tasks/available/{id}' , [TasksManagerController::class, 'getAvailableTasks'])->name('getList');
    Route::get('/tasks' , [ TasksManagerController::class , 'searchTasks'])->name('search.tasks');

});






