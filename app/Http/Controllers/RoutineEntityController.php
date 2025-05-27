<?php

namespace App\Http\Controllers;

use App\Models\RoutineEntity;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class RoutineEntityController 
{
        /**
     * @OA\Get(
     *     path="/api/routines",
     *     summary="Obtener lista de routines",
     *     tags={"routines"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de routines"
     *     )
     * )
     */
    public function getByUserId($user_id)
    {
        $routine = RoutineEntity::where('user_id', $user_id)->get();
        return response()->json($routine);
    }
}