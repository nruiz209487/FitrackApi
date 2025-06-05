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
            'exerciseId' => 'required|integer|exists:exercises,id',
            'date'        => 'required|date',
            'weight'      => 'required|numeric|min:0',
            'reps'        => 'required|integer|min:1',
        ];
    }}