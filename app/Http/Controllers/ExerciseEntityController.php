<?php

namespace App\Http\Controllers;

use App\Models\ExerciseEntity;
use OpenApi\Annotations as OA;
/**
 * Class ExerciseEntityController
 * @package App\Http\Controllers
 *
 * Controlador para la entidad Exercise
 */
class ExerciseEntityController
{
    /**
     * @OA\Get(
     *     path="/api/exercises",
     *     summary="Obtener lista de exercises",
     *     tags={"Exercises"},
     *   security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de exercises"
     *     )
     * )
     */
    public function getAll()
    {
        $list = ExerciseEntity::all();
        return response()->json($list);
    }
}
