<?php

namespace App\Http\Controllers;

use App\Models\TargetLocationEntity;
use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\InsertTargetLocationRequest;
use App\Models\User;
/**
 * Class TargetLocationEntityController
 * @package App\Http\Controllers
 *
 * Controlador para la entidad TargetLocation
 */
class TargetLocationEntityController
{
    /**
     * @OA\Get(
     *     path="/api/target-locations",
     *     summary="Obtener todas las ubicaciones objetivo",
     *     description="Devuelve una lista de todas las entidades de ubicación objetivo.",
     *     tags={"TargetLocation"},
     *     operationId="getAllTargetLocations",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de ubicaciones objetivo",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Casa"),
     *                 @OA\Property(property="position", type="object",
     *                     @OA\Property(property="latitude", type="number", example=19.4326),
     *                     @OA\Property(property="longitude", type="number", example=-99.1332)
     *                 ),
     *                 @OA\Property(property="radiusMeters", type="number", example=50)
     *             )
     *         )
     *     )
     * )
     */
    public function getAll($user_id)
    {
        $list = TargetLocationEntity::where('userId', $user_id)->get()->map(function ($item) {
            [$lat, $lng] = explode(',', $item->position);
            $item->position = [
                'latitude' => (float) $lat,
                'longitude' => (float) $lng,
            ];

            return $item;
        });

        return response()->json($list);
    }


    /**
     * @OA\Post(
     *     path="/api/target-locations/{user_id}",
     *     summary="Crear nueva ubicación objetivo",
     *     description="Crea una nueva ubicación objetivo para un usuario específico.",
     *     tags={"TargetLocation"},
     *     operationId="createTargetLocation",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "position", "radiusMeters"},
     *             @OA\Property(property="name", type="string", example="Casa"),
     *             @OA\Property(property="position", type="string", example="19.4326,-99.1332"),
     *             @OA\Property(property="radiusMeters", type="number", example=50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ubicación creada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function insertByUserId(int $user_id, InsertTargetLocationRequest $request): JsonResponse
    {
            $userExists = User::where('id', $user_id)->exists();

            if (!$userExists) {
                return response()->json([
                    'error' => 'Usuario no encontrado',
                    'message' => "El usuario con ID {$user_id} no existe"
                ], 404);
            }

            $newLocation = TargetLocationEntity::create([
                'name' => $request->input('name'),
                'position' => $request->input('position'),
                'radiusMeters' => $request->input('radiusMeters'),
                'userId' => $user_id,
            ]);

            [$lat, $lng] = explode(',', $newLocation->position);
            $newLocation->position = [
                'latitude' => (float) $lat,
                'longitude' => (float) $lng,
            ];

            return response()->json([
                'message' => 'Ubicación insertada exitosamente',
                'location' => $newLocation
            ], 201);
    }


    /**
     * @OA\Delete(
     *     path="/api/target-locations/{user_id}/{id}",
     *     summary="Eliminar ubicación objetivo de un usuario",
     *     description="Elimina una ubicación objetivo específica asociada a un usuario dado.",
     *     tags={"TargetLocation"},
     *     operationId="deleteTargetLocation",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ubicación eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ubicación no encontrada"
     *     )
     * )
     */
    public function deleteByUserId(int $user_id, int $id): JsonResponse
    {
            $location = TargetLocationEntity::where('userId', $user_id)
                                          ->where('id', $id)
                                          ->first();

            if (!$location) {
                return response()->json([
                    'error' => 'Ubicación no encontrada',
                    'message' => "No se encontró ubicación con ID {$id} para el usuario {$user_id}"
                ], 404);
            }

            $location->delete();

            return response()->json([
                'message' => 'Ubicación eliminada exitosamente'
            ], 200);
    }
}