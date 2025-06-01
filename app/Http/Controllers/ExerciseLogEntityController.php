<?php

namespace App\Http\Controllers;

use App\Models\ExerciseLogEntity;
use OpenApi\Annotations as OA;
use Illuminate\Http\Request;

class ExerciseLogEntityController 
{
    /**
     * @OA\Get(
     *     path="/api/logs/user/{user_id}",
     *     summary="Obtener logs de ejercicios por ID de usuario",
     *     tags={"logs"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de logs del usuario"
     *     )
     * )
     */
    public function getByUserId($user_id)
    {
        $ExerciseLog = ExerciseLogEntity::where('user_id', $user_id)->get();
        return response()->json($ExerciseLog);
    }

    /**
     * @OA\Delete(
     *     path="/api/logs/user/{user_id}/exercise/{exercise_Id}",
     *     summary="Eliminar log de ejercicio por usuario y ejercicio",
     *     tags={"logs"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="exercise_Id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Exercise Log deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Exercise Log not found"
     *     )
     * )
     */
    public function deleteByUserId($user_id , $exercise_Id)
    {
        $exerciseLog = NoteEntity::where('user_id', $user_id)->where('exerciseId', $exercise_Id)->first();
        if ($exerciseLog) {
            $exerciseLog->delete();
            return response()->json(['message' => 'Exercise Log deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Exercise Log not found'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/logs/user/{user_id}/insert",
     *     summary="Insertar rutina por usuario",
     *     tags={"logs"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Routine insertada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Routine ya existe para ese usuario"
     *     )
     * )
     */
    public function insertByUserId($user_id, InsertRoutineRequest $request)
    {
        $exercise_log_id = $request->input('id');

        $routine = RoutineEntity::where('user_id', $user_id)
                                ->where('id', $exercise_log_id)
                                ->first();

        if ($routine) {
            return response()->json(['message' => 'Routine ya existe para ese usuario'], 200);
        } else {
            $newRoutine = RoutineEntity::create([
                'user_id' => $user_id,
                'id' => $exercise_log_id, 
            ]);
            return response()->json(['message' => 'Routine insertada exitosamente', 'routine' => $newRoutine], 201);
        }
    }

}