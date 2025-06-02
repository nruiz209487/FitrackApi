<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciseEntityController;
use App\Http\Controllers\ExerciseLogEntityController;
use App\Http\Controllers\NoteEntityController;
use App\Http\Controllers\RoutineEntityController;
use App\Http\Controllers\UserEntityController;
use App\Http\Controllers\TargetLocationEntityController;

// Public routes
Route::post('/user/register', [UserEntityController::class, 'register']);
Route::get('/user/token/{user_id}', [UserEntityController::class, 'getByUserId']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // User routes
    Route::put('/user/{id}', [UserEntityController::class, 'updateRequest']);
    Route::delete('/user/{id}', [UserEntityController::class, 'delete']);

    // Exercise routes
    Route::get('/exercises', [ExerciseEntityController::class, 'getAll']);

    // Target Location routes
    Route::get('/targetlocations', [TargetLocationEntityController::class, 'getAll']);

    // Exercise Log routes
    Route::get('/logs/user/{user_id}', [ExerciseLogEntityController::class, 'getByUserId']);
    Route::post('/logs/user/{user_id}/insert', [ExerciseLogEntityController::class, 'insertByUserId']);
    Route::delete('/logs/user/{user_id}/exercise/{exercise_Id}', [ExerciseLogEntityController::class, 'deleteByUserId']);

    // Note routes
    Route::get('/notes/user/{user_id}', [NoteEntityController::class, 'getByUserId']);
    Route::post('/logs/user/{user_id}/note', [NoteEntityController::class, 'insertByUserId']);
    Route::delete('/logs/user/{user_id}/note/{id}', [NoteEntityController::class, 'deleteByUserId']);

    // Routine routes
    Route::get('/routines/user/{user_id}', [RoutineEntityController::class, 'getByUserId']);
    Route::get('/users/{user_id}/routines', [RoutineEntityController::class, 'getByUserId']);
    Route::post('/users/{user_id}/routines', [RoutineEntityController::class, 'insertByUserId']);
    Route::delete('/users/{user_id}/routines/{routine_id}', [RoutineEntityController::class, 'deleteByUserId']);
});
