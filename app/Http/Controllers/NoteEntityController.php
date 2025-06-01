<?php

namespace App\Http\Controllers;

use App\Models\NoteEntity;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Http\Requests\InsertNoteRequest;

class NoteEntityController 
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
        $note = NoteEntity::where('user_id', $user_id)->get();
        return response()->json($note);
    }

    /**
     * @OA\Delete(
     *     path="/api/logs/user/{user_id}/note/{id}",
     *     summary="Eliminar una nota por ID de usuario e ID de nota",
     *     tags={"logs"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
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
        $note = NoteEntity::where('user_id', $user_id)->where('id', $id)->first();
        if ($note) {
            $note->delete();
            return response()->json(['message' => 'Note deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Note not found'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/logs/user/{user_id}/note",
     *     summary="Insertar una nueva nota para un usuario",
     *     tags={"logs"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
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

        $note = NoteEntity::where('user_id', $user_id)
                          ->where('id', $note_id)
                          ->first();

        if ($note) {
            return response()->json(['message' => 'Note ya existe para ese usuario'], 200);
        } else {
            $newNote = NoteEntity::create([
                'user_id' => $user_id,
                'id' => $note_id, 
            ]);
            return response()->json(['message' => 'Note insertada exitosamente', 'note' => $newNote], 201);
        }
    }
}