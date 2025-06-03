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
        $list = TargetLocationEntity::all();
        return response()->json($list);
    }
}
