<?php

namespace App\Http\Controllers;

use App\Models\ExerciseLogEntity;
use OpenApi\Annotations as OA;

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
}