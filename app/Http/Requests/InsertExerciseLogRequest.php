<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class InsertExerciseLogRequest
 * @package App\Http\Requests
 *
 * La clase InsertExerciseLogRequest se utiliza para validar las solicitudes de inserción de registros de ejercicios.
 */
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
     *reglas para actualizar un usuario
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