<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TasksManagerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::prefix('tasks')->controller(TaskController::class)->group(function () {
    Route::get('/', 'index')->name('tasks');

});



Route::prefix('/make/manager')->name('make.manager.')->group(function () {

    Route::post('/create', [TasksManagerController::class, 'create'])->name('create');
    Route::patch('/update/{id}/status', [TasksManagerController::class, 'update'])->name('update');

});






