<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciseEntityController;
use App\Http\Controllers\ExerciseLogEntityController;
use App\Http\Controllers\NoteEntityController;
use App\Http\Controllers\RoutineEntityController;
use App\Http\Controllers\UserEntityControlloer;

Route::get('/exercises', [ExerciseEntityController::class, 'getAll']);
Route::get('/logs/user/{user_id}', [ExerciseLogEntityController::class, 'getByUserId']);
Route::get('/notes/user/{user_id}', [NoteEntityController::class, 'getByUserId']);
Route::get('/routines/user/{user_id}', [RoutineEntityController::class, 'getByUserId']);
Route::post('/user/register', [UserEntityControlloer::class, 'register']);
