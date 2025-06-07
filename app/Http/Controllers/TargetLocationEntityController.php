<?php

namespace App\Http\Controllers;

use App\Models\TargetLocationEntity;
use OpenApi\Annotations as OA;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TargetLocationEntityController
{
    /**
     * @OA\Get(
     *     path="/api/target-locations",
     *     summary="Obtener todas las ubicaciones objetivo",
     *     description="Devuelve una lista de todas las entidades de ubicación objetivo.",
     *     tags={"TargetLocation"},
     *     operationId="getAllTargetLocations",
     *   security={{"bearerAuth":{}}},
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
    public function getAll()
    {
        $list = TargetLocationEntity::all()->map(function ($item) {
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
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function insertByUserId(int $user_id, Request $request): JsonResponse
    {
        try {
            // Reglas de validación
            $rules = [
                'name' => 'required|string|max:255',
                'position' => 'required|string|regex:/^-?\d+\.?\d*,-?\d+\.?\d*$/', // formato: "lat,lng"
                'radiusMeters' => 'required|numeric|min:0',
            ];

            // Validar el request
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validación fallida',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Verificar que el usuario existe (opcional pero recomendado)
            $userExists = \App\Models\User::where('id', $user_id)->exists();
            if (!$userExists) {
                return response()->json([
                    'error' => 'Usuario no encontrado',
                    'message' => "El usuario con ID {$user_id} no existe"
                ], 404);
            }

            // Crear la nueva ubicación
            $newLocation = TargetLocationEntity::create([
                'name' => $request->input('name'),
                'position' => $request->input('position'),
                'radiusMeters' => $request->input('radiusMeters'),
                'userId' => $user_id,
            ]);

            // Transformar position para la respuesta
            [$lat, $lng] = explode(',', $newLocation->position);
            $newLocation->position = [
                'latitude' => (float) $lat,
                'longitude' => (float) $lng,
            ];

            return response()->json([
                'message' => 'Ubicación insertada exitosamente',
                'location' => $newLocation
            ], 201);

        } catch (\Exception $e) {
            // Log del error detallado
            Log::error('Error al insertar ubicación', [
                'user_id' => $user_id,
                'input' => $request->all(),
                'exception_class' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // Respuesta clara en JSON
            return response()->json([
                'error' => 'Error interno al insertar ubicación',
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'hint' => 'Revisa storage/logs/laravel.log para más detalles'
            ], 500);
        }
    }

    /**
     * Eliminar ubicación por usuario e ID
     */
    public function deleteByUserId(int $user_id, int $id): JsonResponse
    {
        try {
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

        } catch (\Exception $e) {
            Log::error('Error al eliminar ubicación', [
                'user_id' => $user_id,
                'location_id' => $id,
                'exception' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Error interno al eliminar ubicación',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}