<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertExerciseLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exerciseId' => 'required|integer',
            'date'        => 'required|date',
            'weight'      => 'required|numeric|min:0',
            'reps'        => 'required|integer|min:1',
        ];
    }}