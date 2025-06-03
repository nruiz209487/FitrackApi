<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertExerciseLogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'exercise_id' => 'required|integer|exists:exercises,id',
            'date'        => 'required|date',
            'weight'      => 'required|numeric|min:0',
            'reps'        => 'required|integer|min:1',
            'userId'     => 'required|integer|exists:users,id',
        ];
    }
}
