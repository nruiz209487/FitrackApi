<?php

namespace App\Http\Controllers;

use App\Models\ExerciseLogEntity;
use OpenApi\Annotations as OA;
use App\Http\Requests\InsertExerciseLogRequest;

class ExerciseLogEntityController 
{

    public function getByUserId($user_id)
    {
        $ExerciseLog = ExerciseLogEntity::where('user_id', $user_id)->get();
        return response()->json($ExerciseLog);
    }

    public function deleteByUserId($user_id , $exercise_Id)
    {
        $exerciseLog = ExerciseLogEntity::where('user_id', $user_id)->where('exerciseId', $exercise_Id)->first();
        if ($exerciseLog) {
            $exerciseLog->delete();
            return response()->json(['message' => 'Exercise Log deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Exercise Log not found'], 404);
        }
    }


    public function insertByUserId($user_id, InsertExerciseLogRequest $request)
    {
        $exercise_log_id = $request->input('id');

        $routine = ExerciseLogEntity::where('user_id', $user_id)
                                ->where('id', $exercise_log_id)
                                ->first();

        if ($routine) {
            return response()->json(['message' => 'Routine ya existe para ese usuario'], 200);
        } else {
            $newRoutine = ExerciseLogEntity::create([
                'user_id' => $user_id,
                'id' => $exercise_log_id, 
            ]);
            return response()->json(['message' => 'Routine insertada exitosamente', 'routine' => $newRoutine], 201);
        }
    }

}