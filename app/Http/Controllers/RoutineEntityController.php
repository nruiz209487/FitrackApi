<?php

namespace App\Http\Controllers;

use App\Models\RoutineEntity;
use App\Http\Requests\InsertRoutineRequest;
use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;

class RoutineEntityController
{
    /**
     * @OA\Get(
     *     path="/api/routines/{user_id}",
     *     summary="Obtener las rutinas por ID de usuario",
     *     tags={"Routine"},
     *     operationId="getRoutinesByUserId",
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
     *         description="Lista de rutinas del usuario"
     *     )
     * )
     */
    public function getByUserId(int $user_id): JsonResponse
    {
        $routines = RoutineEntity::where('userId', $user_id)->get();
        return response()->json($routines);
    }

    /**
     * @OA\Delete(
     *     path="/api/routines/{user_id}/{routine_id}",
     *     summary="Eliminar una rutina por ID de usuario e ID de rutina",
     *     tags={"Routine"},
     *     operationId="deleteRoutineByUserIdAndRoutineId",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="routine_id",
     *         in="path",
     *         required=true,
     *         description="ID de la rutina",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rutina eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rutina no encontrada"
     *     )
     * )
     */
    public function deleteByUserId(int $user_id, int $routine_id): JsonResponse
    {
        $routine = RoutineEntity::where('userId', $user_id)
            ->where('id', $routine_id)
            ->first();

        if (!$routine) {
            return response()->json(['message' => 'Routine no encontrada'], 404);
        }

        $routine->delete();
        return response()->json(['message' => 'Routine eliminada exitosamente'], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/routines/{user_id}",
     *     summary="Insertar una nueva rutina para un usuario",
     *     tags={"Routine"},
     *     operationId="insertRoutineByUserId",
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
     *             required={"name", "description", "imageUri", "exerciseIds"},
     *             @OA\Property(property="name", type="string", example="Rutina de pierna"),
     *             @OA\Property(property="description", type="string", example="Ejercicios centrados en piernas y glúteos"),
     *             @OA\Property(property="imageUri", type="string", example="https://miapp.com/images/pierna.png"),
     *             @OA\Property(
     *                 property="exerciseIds", 
     *                 type="array",
     *                 @OA\Items(type="integer"),
     *                 example={101, 102, 103}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rutina insertada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Routine insertada exitosamente"),
     *             @OA\Property(property="routine", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="La rutina ya existe para ese usuario"
     *     )
     * )
     */
    public function insertByUserId(int $user_id, InsertRoutineRequest $request): JsonResponse
    {
        // Buscar si ya existe una rutina con el mismo nombre para el usuario
        $existingRoutine = RoutineEntity::where('userId', $user_id)
            ->where('name', $request->input('name'))
            ->first();

        if ($existingRoutine) {
            return response()->json(['message' => 'Routine ya existe para ese usuario'], 200);
        }


        $newRoutine = RoutineEntity::create([
            'userId'      => $user_id,
            'name'        => $request->input('name'),
            'description' => $request->input('description') ?? '',
            'imageUri'    => $request->input('imageUri') ?? '',
            'exerciseIds' => $request->input('exerciseIds') ?? '',
        ]);

        return response()->json([
            'message' => 'Routine insertada exitosamente',
            'routine' => $newRoutine
        ], 201);
    }
}
