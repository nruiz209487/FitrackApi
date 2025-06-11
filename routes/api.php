<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciseEntityController;
use App\Http\Controllers\ExerciseLogEntityController;
use App\Http\Controllers\NoteEntityController;
use App\Http\Controllers\RoutineEntityController;
use App\Http\Controllers\UserEntityController;
use App\Http\Controllers\TargetLocationEntityController;


Route::get('/server-working', function () {
    return response()->json(['message' => 'Server working'], 200);
})->middleware(['throttle:5,1']);

// User authentication routes
Route::post('/user/register', [UserEntityController::class, 'register'])->middleware(['throttle:5,1']);
Route::post('/user/{email}', [UserEntityController::class, 'getByEmail'])->middleware(['throttle:5,1']);

//sanctum authentication routes
Route::middleware('auth:sanctum')->group(function () {

    // UserEntityController
    Route::delete('/user/delete/{id}', [UserEntityController::class, 'delete']);
    Route::put('/user/update/{id}', [UserEntityController::class, 'updateRequest']);

    // ExerciseEntityController
    Route::get('/exercises', [ExerciseEntityController::class, 'getAll']);

    // ExerciseLogEntityController
    Route::post('/exercise-log/{user_id}', [ExerciseLogEntityController::class, 'insertByUserId']);
    Route::get('/exercise-log/{user_id}', [ExerciseLogEntityController::class, 'getByUserId']);
    Route::delete('/exercise-log/{user_id}/{exercise_Id}', [ExerciseLogEntityController::class, 'deleteByUserId']);

    // NoteEntityController
    Route::post('/note/{user_id}', [NoteEntityController::class, 'insertByUserId']);
    Route::get('/notes/{user_id}', [NoteEntityController::class, 'getByUserId']);
    Route::delete('/notes/{user_id}/{id}', [NoteEntityController::class, 'deleteByUserId']);

    // RoutineEntityController
    Route::post('/routines/{user_id}', [RoutineEntityController::class, 'insertByUserId']);
    Route::get('/routines/{user_id}', [RoutineEntityController::class, 'getByUserId']);
    Route::delete('/routines/{user_id}/{routine_id}', [RoutineEntityController::class, 'deleteByUserId']);

    // TargetLocationEntityController
    Route::get('/target-locations/{user_id}', [TargetLocationEntityController::class, 'getAll']);
    Route::delete('/target-locations/{user_id}/{id}', [TargetLocationEntityController::class, 'deleteByUserId']);
    Route::post('/target-locations/{user_id}', [TargetLocationEntityController::class, 'insertByUserId']);
});
