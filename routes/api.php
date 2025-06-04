<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciseEntityController;
use App\Http\Controllers\ExerciseLogEntityController;
use App\Http\Controllers\NoteEntityController;
use App\Http\Controllers\RoutineEntityController;
use App\Http\Controllers\UserEntityController;
use App\Http\Controllers\TargetLocationEntityController;

Route::post('/user/register', [UserEntityController::class, 'register']);
Route::get('/user/{user_id}', [UserEntityController::class, 'getByUserId']);
Route::put('/user/update/{id}', [UserEntityController::class, 'updateRequest']);
Route::post('/exercise-log/{user_id}', [ExerciseLogEntityController::class, 'insertByUserId']);
Route::post('/note/{user_id}', [NoteEntityController::class, 'insertByUserId']);
Route::post('/routines/{user_id}', [RoutineEntityController::class, 'insertByUserId']);

// User routes

Route::delete('/user/delete/{id}', [UserEntityController::class, 'delete']);

// Exercise routes
Route::get('/exercises', [ExerciseEntityController::class, 'getAll']);

// Target Location routes
Route::get('/target-locations', [TargetLocationEntityController::class, 'getAll']);

// Exercise Log routes
Route::get('/exercise-log/{user_id}', [ExerciseLogEntityController::class, 'getByUserId']);

Route::delete('/exercise-log/{user_id}/{exercise_Id}', [ExerciseLogEntityController::class, 'deleteByUserId']);

// Note routes
Route::get('/notes/{user_id}', [NoteEntityController::class, 'getByUserId']);

Route::delete('/notes/{user_id}/{id}', [NoteEntityController::class, 'deleteByUserId']);

// Routine routes
Route::get('/routines/{user_id}', [RoutineEntityController::class, 'getByUserId']);

Route::delete('/routines/{user_id}/{routine_id}', [RoutineEntityController::class, 'deleteByUserId']);

Route::middleware('auth:sanctum')->group(function () {

});
