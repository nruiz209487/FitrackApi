<?php

namespace App\Http\Controllers;

use App\Models\NoteEntity;
use OpenApi\Annotations as OA;
use App\Http\Requests\InsertNoteRequest;

class NoteEntityController 
{
    /**
     * @OA\Get(
     *     path="/notes/user/{user_id}",
     *     summary="Get notes by user ID",
     *     tags={"Notes"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of notes"
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
     *     path="/notes/user/{user_id}/{id}",
     *     summary="Delete a note by user ID and note ID",
     *     tags={"Notes"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the note",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Note deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Note not found"
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
     *     path="/notes/user/{user_id}",
     *     summary="Insert a note by user ID",
     *     tags={"Notes"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
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
     *         description="Note inserted successfully"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Note already exists for this user"
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