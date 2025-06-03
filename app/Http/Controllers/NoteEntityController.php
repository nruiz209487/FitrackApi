<?php

namespace App\Http\Controllers;

use App\Models\NoteEntity;
use OpenApi\Annotations as OA;
use App\Http\Requests\InsertNoteRequest;

class NoteEntityController
{
    /**
     * @OA\Get(
     *     path="/api/notes/user/{user_id}",
     *     summary="Obtener notas por ID de usuario",
     *     tags={"Notes"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de notas"
     *     )
     * )
     */
    public function getByUserId($user_id)
    {
        $notes = NoteEntity::where('userId', $user_id)->get();
        return response()->json($notes);
    }

    /**
     * @OA\Delete(
     *     path="/api/notes/user/{user_id}/{id}",
     *     summary="Eliminar una nota por ID de usuario e ID de nota",
     *     tags={"Notes"},
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
     *         description="Nota eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Nota no encontrada"
     *     )
     * )
     */
    public function deleteByUserId($user_id, $id)
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
     *     path="/api/notes/user/{user_id}",
     *     summary="Insertar una nueva nota por ID de usuario",
     *     tags={"Notes"},
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
     *             @OA\Property(property="id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Nota insertada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="La nota ya existe para ese usuario"
     *     )
     * )
     */
    public function insertByUserId($user_id, InsertNoteRequest $request)
    {
        $note_id = $request->input('id');

        $existingNote = NoteEntity::where('userId', $user_id)
            ->where('id', $note_id)
            ->first();

        if ($existingNote) {
            return response()->json(['message' => 'La nota ya existe para ese usuario'], 200);
        }

        $newNote = NoteEntity::create([
            'userId' => $user_id,
            'id'     => $note_id,
        ]);

        return response()->json([
            'message' => 'Nota insertada exitosamente',
            'note'    => $newNote
        ], 201);
    }
}
