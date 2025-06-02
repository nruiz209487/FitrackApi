<?php

namespace App\Http\Controllers;

use App\Models\NoteEntity;
use OpenApi\Annotations as OA;
use App\Http\Requests\InsertNoteRequest;

class NoteEntityController 
{

    public function getByUserId($user_id)
    {
        $note = NoteEntity::where('user_id', $user_id)->get();
        return response()->json($note);
    }

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