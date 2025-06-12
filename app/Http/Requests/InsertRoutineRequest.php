<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * Class InsertRoutineRequest
 * @package App\Http\Requests
 *
 * La clase InsertRoutineRequest se utiliza para validar las solicitudes de inserción de rutinas.
 */
class InsertRoutineRequest extends FormRequest
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
     * reglas para insertar una rutina
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'imageUri' => 'nullable|string|max:255',
            'exerciseIds' => 'nullable|string|max:255',
        ];
    }
}
