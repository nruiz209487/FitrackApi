<?php

namespace App\Http\Controllers;

use App\Models\ExerciseLogEntity;
use OpenApi\Annotations as OA;
use App\Http\Requests\InsertExerciseLogRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ExerciseLogEntityController
{
    /**
     * @OA\Get(
     *     path="/api/exercise-log/{user_id}",
     *     operationId="getExerciseLogsByUserId",
     *     summary="Obtener logs de ejercicio por ID de usuario",
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
     *     operationId="deleteExerciseLogByUserIdAndExerciseId",
     *     summary="Eliminar un log de ejercicio por ID de usuario e ID de ejercicio",
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
     *         description="ID del ejercicio",
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
            ->where('exerciseId', $exercise_Id)
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
     *     operationId="insertExerciseLogByUserId",
     *     summary="Insertar un nuevo log de ejercicio para un usuario",
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
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function insertByUserId(int $user_id, Request $request): JsonResponse
    {
        try {
            // Debug: Log datos recibidos
            Log::info('POST exercise-log recibido:', [
                'user_id' => $user_id,
                'body' => $request->all()
            ]);

            // Validación manual básica (sin exists check)
            $rules = [
                'exercise_id' => 'required|integer',
                'date'        => 'required|date',
                'weight'      => 'required|numeric|min:0',
                'reps'        => 'required|integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Buscar si ya existe
            $existingLog = ExerciseLogEntity::where('userId', $user_id)
                ->where('exerciseId', $request->input('exercise_id'))
                ->where('date', $request->input('date'))
                ->first();

            if ($existingLog) {
                return response()->json(['message' => 'Exercise Log ya existe para ese usuario'], 200);
            }

            // Crear nuevo log
            $newLog = ExerciseLogEntity::create([
                'userId'     => $user_id,
                'exerciseId' => $request->input('exercise_id'),
                'date'       => $request->input('date'),
                'weight'     => $request->input('weight'),
                'reps'       => $request->input('reps'),
            ]);

            return response()->json([
                'message' => 'Exercise Log insertado exitosamente',
                'exercise_log' => $newLog
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error insertByUserId:', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json([
                'error' => 'Error interno',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
