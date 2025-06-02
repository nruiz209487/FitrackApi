<?php

namespace App\Http\Controllers;

use App\Models\RoutineEntity;
use App\Http\Requests\InsertRoutineRequest;
use OpenApi\Annotations as OA;
use Illuminate\Http\JsonResponse;

class RoutineEntityController
{

    public function getByUserId(int $user_id): JsonResponse
    {
        $routines = RoutineEntity::where('user_id', $user_id)->get();
        return response()->json($routines);
    }

    public function deleteByUserId(int $user_id, int $routine_id): JsonResponse
    {
        $routine = RoutineEntity::where('user_id', $user_id)
            ->where('id', $routine_id)
            ->first();

        if (!$routine) {
            return response()->json(['message' => 'Routine no encontrada'], 404);
        }

        $routine->delete();
        return response()->json(['message' => 'Routine eliminada exitosamente'], 200);
    }

    public function insertByUserId(int $user_id, InsertRoutineRequest $request): JsonResponse
    {
        $routine_id = $request->input('id');

        $existingRoutine = RoutineEntity::where('user_id', $user_id)
            ->where('id', $routine_id)
            ->first();

        if ($existingRoutine) {
            return response()->json(['message' => 'Routine ya existe para ese usuario'], 200);
        }

        $newRoutine = RoutineEntity::create([
            'user_id' => $user_id,
            'id' => $routine_id,
        ]);

        return response()->json([
            'message' => 'Routine insertada exitosamente',
            'routine' => $newRoutine
        ], 201);
    }
}
