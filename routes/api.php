<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::prefix('tasks')->controller(TaskController::class)->group(function () {
    Route::get('/', 'index')->name('tasks');


    


});





