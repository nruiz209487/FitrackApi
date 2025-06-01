<?php

namespace App\Http\Controllers;

use App\Models\RoutineEntity;
use Illuminate\Http\Request;
use App\Http\Requests\InsertRoutineRequest;
use OpenApi\Annotations as OA;

class RoutineEntityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users/{user_id}/routines",
     *     summary="Obtener lista de routines de un usuario",
     *     tags={"routines"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de routines",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/RoutineEntity"))
     *     )
     * )
     */
    public function getByUserId($user_id)
    {
        $routine = RoutineEntity::where('user_id', $user_id)->get();
        return response()->json($routine);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{user_id}/routines/{routine_id}",
     *     summary="Eliminar una routine de un usuario",
     *     tags={"routines"},
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
     *         description="ID de la routine",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Routine eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Routine no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function deleteByUserId($user_id, $routine_id)
    {
        $routine = RoutineEntity::where('user_id', $user_id)->where('id', $routine_id)->first();

        if ($routine) {
            $routine->delete();
            return response()->json(['message' => 'Routine deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Routine not found'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/users/{user_id}/routines",
     *     summary="Insertar una routine para un usuario",
     *     tags={"routines"},
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
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", description="ID de la routine")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Routine insertada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="routine", ref="#/components/schemas/RoutineEntity")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Routine ya existe para ese usuario",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function insertByUserId($user_id, InsertRoutineRequest $request)
    {
        $routine_id = $request->input('id');

        $routine = RoutineEntity::where('user_id', $user_id)
                                ->where('id', $routine_id)
                                ->first();

        if ($routine) {
            return response()->json(['message' => 'Routine ya existe para ese usuario'], 200);
        } else {
            $newRoutine = RoutineEntity::create([
                'user_id' => $user_id,
                'id' => $routine_id, 
            ]);
            return response()->json(['message' => 'Routine insertada exitosamente', 'routine' => $newRoutine], 201);
        }
    }
}
