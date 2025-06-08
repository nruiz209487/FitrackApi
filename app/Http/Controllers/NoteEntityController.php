<?php

namespace App\Http\Controllers;

use App\Models\NoteEntity;
use OpenApi\Annotations as OA;
use App\Http\Requests\InsertNoteRequest;
use Illuminate\Http\JsonResponse;

class NoteEntityController
{
    /**
     * @OA\Get(
     *     path="/api/notes/{user_id}",
     *     summary="Obtener notas por ID de usuario",
     *     tags={"Notes"},
     *     operationId="getNotesByUserId",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de notas del usuario",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="userId", type="integer", example=123),
     *                 @OA\Property(property="header", type="string", example="Nota importante"),
     *                 @OA\Property(property="text", type="string", example="Este es el texto de la nota"),
     *                 @OA\Property(property="timestamp", type="string", format="date-time", example="2025-06-04T14:30:00")
     *             )
     *         )
     *     )
     * )
     */
    public function getByUserId(int $user_id): JsonResponse
    {
        $notes = NoteEntity::where('userId', $user_id)->get();
        return response()->json($notes);
    }

    /**
     * @OA\Delete(
     *     path="/api/notes/{user_id}/{id}",
     *     summary="Eliminar una nota por ID de usuario e ID de nota",
     *     tags={"Notes"},
     *     operationId="deleteNoteByUserIdAndId",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la nota",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Nota eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nota eliminada exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nota no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nota no encontrada")
     *         )
     *     )
     * )
     */
    public function deleteByUserId(int $user_id, int $id): JsonResponse
    {
        $note = NoteEntity::where('userId', $user_id)
            ->where('id', $id)
            ->first();

        if ($note) {
            $note->delete();
            return response()->json(['message' => 'Nota eliminada exitosamente'], 200);
        }

        return response()->json(['message' => 'Nota no encontrada'], 404);
    }

    /**
     * @OA\Post(
     *     path="/api/note/{user_id}",
     *     summary="Insertar una nueva nota por ID de usuario",
     *     tags={"Notes"},
     *     operationId="insertNoteByUserId",
     *     security={{"bearerAuth":{}}},
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
     *             required={"header", "text", "timestamp"},
     *             @OA\Property(property="header", type="string", example="Reunión con el equipo"),
     *             @OA\Property(property="text", type="string", example="Discutimos el progreso del proyecto y se asignaron nuevas tareas."),
     *             @OA\Property(property="timestamp", type="string", format="date-time", example="2025-06-04T14:30:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Nota insertada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nota insertada exitosamente"),
     *             @OA\Property(property="note", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="La nota ya existe para ese usuario",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="La nota ya existe para ese usuario")
     *         )
     *     )
     * )
     */
    public function insertByUserId(int $user_id, InsertNoteRequest $request): JsonResponse
    {
        $existingNote = NoteEntity::where('userId', $user_id)
            ->where('header', $request->input('header'))
            ->where('timestamp', $request->input('timestamp'))
            ->first();

        if ($existingNote) {
            return response()->json(['message' => 'La nota ya existe para ese usuario'], 200);
        }

        $newNote = NoteEntity::create([
            'userId'     => $user_id,
            'header'     => $request->input('header'),
            'text'       => $request->input('text'),
            'timestamp'  => $request->input('timestamp'),
        ]);

        return response()->json([
            'message' => 'Nota insertada exitosamente',
            'note'    => $newNote
        ], 201);
    }
}
