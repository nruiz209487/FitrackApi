<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertRoutineRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'imageUri' => 'nullable|string|max:255',
            'exerciseIds' => 'required|array',
            'exerciseIds.*' => 'integer|exists:exercises,id',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
