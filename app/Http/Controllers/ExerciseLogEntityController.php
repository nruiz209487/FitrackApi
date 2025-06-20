<?php

namespace App\Http\Controllers;

use App\Models\ExerciseLogEntity;
use OpenApi\Annotations as OA;
use App\Http\Requests\InsertExerciseLogRequest;
use Illuminate\Http\JsonResponse;
/**
 * Class ExerciseLogEntityController
 * @package App\Http\Controllers
 *
 * Controlador para la entidad ExerciseLog
 */
class ExerciseLogEntityController
{
    /**
     * @OA\Get(
     *     path="/api/exercise-log/{user_id}",
     *     summary="Obtener logs de ejercicio por ID de usuario",
     *     description="Devuelve todos los registros de ejercicio de un usuario específico.",
     *     operationId="getExerciseLogsByUserId",
     *     tags={"ExerciseLog"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de logs de ejercicio del usuario",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="userId", type="integer", example=123),
     *                 @OA\Property(property="exerciseId", type="integer", example=1),
     *                 @OA\Property(property="date", type="string", format="date", example="2024-06-01"),
     *                 @OA\Property(property="weight", type="number", format="float", example=50.5),
     *                 @OA\Property(property="reps", type="integer", example=10)
     *             )
     *         )
     *     )
     * )
     */
    public function getByUserId(int $user_id): JsonResponse
    {
        $exerciseLog = ExerciseLogEntity::where('userId', $user_id)->get();
        return response()->json($exerciseLog);
    }

    /**
     * @OA\Delete(
     *     path="/api/exercise-log/{user_id}/{exercise_Id}",
     *     summary="Eliminar un log de ejercicio por ID de usuario e ID de ejercicio",
     *     description="Elimina un registro de ejercicio específico de un usuario.",
     *     operationId="deleteExerciseLogByUserIdAndExerciseId",
     *     tags={"ExerciseLog"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="exercise_Id",
     *         in="path",
     *         required=true,
     *         description="ID del log de ejercicio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Log eliminado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Exercise Log deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Log no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Exercise Log not found")
     *         )
     *     )
     * )
     */
    public function deleteByUserId(int $user_id, int $exercise_Id): JsonResponse
    {
        $exerciseLog = ExerciseLogEntity::where('userId', $user_id)
            ->where('id', $exercise_Id)
            ->first();

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
     *     summary="Insertar un nuevo log de ejercicio para un usuario",
     *     description="Inserta un nuevo registro de ejercicio para un usuario si no existe ya con la misma fecha y ejercicio.",
     *     operationId="insertExerciseLogByUserId",
     *     tags={"ExerciseLog"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"exercise_id", "date", "weight", "reps"},
     *             @OA\Property(property="exercise_id", type="integer", example=1),
     *             @OA\Property(property="date", type="string", format="date", example="2025-06-04"),
     *             @OA\Property(property="weight", type="number", format="float", example=75.0),
     *             @OA\Property(property="reps", type="integer", example=12)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Log insertado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Exercise Log insertado exitosamente"),
     *             @OA\Property(property="exercise_log", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="El log ya existe para ese usuario",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Exercise Log ya existe para ese usuario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error interno"),
     *             @OA\Property(property="message", type="string", example="Ocurrió un error inesperado")
     *         )
     *     )
     * )
     */
    public function insertByUserId(int $user_id, InsertExerciseLogRequest $request): JsonResponse
    {
        $newLog = ExerciseLogEntity::create([
            'userId'     => $user_id,
            'exerciseId' => $request->input('exerciseId'),
            'date'       => $request->input('date'),
            'weight'     => $request->input('weight'),
            'reps'       => $request->input('reps'),
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Exercise Log insertado exitosamente',
            'exercise_log' => $newLog
        ], 201);
        }
}
