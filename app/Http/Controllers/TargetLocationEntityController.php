<?php

namespace App\Http\Controllers;

use App\Models\TargetLocationEntity;
use OpenApi\Annotations as OA;

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
     *                 @OA\Property(property="name", type="string", example="Pecho"),
     *                 @OA\Property(property="description", type="string", example="Grupo muscular de la parte superior del torso")
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
public function insertByUserId(int $user_id, Request $request): JsonResponse
{
    try {
        // Reglas de validación
        $rules = [
            'name' => 'required|string',
            'position' => 'required|string', // formato: "lat,lng"
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

        // Crear nueva ubicación
        $newLocation = TargetLocationEntity::create([
            'name' => $request->input('name'),
            'position' => $request->input('position'),
            'radiusMeters' => $request->input('radiusMeters'),
        ]);

        return response()->json([
            'message' => 'Ubicación insertada exitosamente',
            'location' => $newLocation
        ], 201);

    } catch (\Exception $e) {
        // Log del error detallado
        \Log::error('Error al insertar ubicación', [
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


}
