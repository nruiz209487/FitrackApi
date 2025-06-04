<?php
namespace App\Http\Controllers;

use App\Models\ExerciseEntity;
use OpenApi\Annotations as OA;

class ExerciseEntityController
{
    /**
     * @OA\Get(
     *     path="/api/exercises",
     *     summary="Obtener lista de exercises",
     *     tags={"exercises"},
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
