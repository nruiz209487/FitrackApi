<?php

namespace App\Http\Controllers;

use App\Models\ExerciseLogEntity;
use OpenApi\Annotations as OA;
use App\Http\Requests\InsertExerciseLogRequest;

class ExerciseLogEntityController
{
    /**
     * @OA\Get(
     *     path="/api/exercise-log/{user_id}",
     *     operationId="getExerciseLogsByUserId",
     *     summary="Obtener logs de ejercicio por ID de usuario",
     *     tags={"ExerciseLog"},
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
        $ExerciseLog = ExerciseLogEntity::where('userId', $user_id)->get();
        return response()->json($ExerciseLog);
    }

    /**
     * @OA\Delete(
     *     path="/api/exercise-log/{user_id}/{exercise_Id}",
     *     operationId="deleteExerciseLogByUserIdAndExerciseId",
     *     summary="Eliminar un log de ejercicio por ID de usuario e ID de ejercicio",
     *     tags={"ExerciseLog"},
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
     *         description="Log eliminado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Log no encontrado"
     *     )
     * )
     */
    public function deleteByUserId($user_id, $exercise_Id)
    {
        $exerciseLog = ExerciseLogEntity::where('userId', $user_id)->where('exerciseId', $exercise_Id)->first();
        if ($exerciseLog) {
            $exerciseLog->delete();
            return response()->json(['message' => 'Exercise Log deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Exercise Log not found'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/exercise-log/{user_id}",
     *     operationId="insertExerciseLogByUserId",
     *     summary="Insertar un nuevo log de ejercicio para un usuario",
     *     tags={"ExerciseLog"},
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
     *         description="Log insertado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="El log ya existe para ese usuario"
     *     )
     * )
     */
    public function insertByUserId($user_id, InsertExerciseLogRequest $request)
    {
        $exercise_log_id = $request->input('id');

        $routine = ExerciseLogEntity::where('userId', $user_id)
            ->where('id', $exercise_log_id)
            ->first();

        if ($routine) {
            return response()->json(['message' => 'Routine ya existe para ese usuario'], 200);
        } else {
            $newRoutine = ExerciseLogEntity::create([
                'userId' => $user_id,
                'id' => $exercise_log_id,
            ]);
            return response()->json(['message' => 'Routine insertada exitosamente', 'routine' => $newRoutine], 201);
        }
    }
}
