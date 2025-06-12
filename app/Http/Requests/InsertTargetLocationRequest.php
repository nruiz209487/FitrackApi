<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * Class InsertTargetLocationRequest
 * @package App\Http\Requests
 * la clase InsertTargetLocationRequest se utiliza para validar las solicitudes de inserción de ubicaciones objetivo.
 */
class InsertTargetLocationRequest extends FormRequest
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
     * reglas para insertar una ubicación objetivo
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'required|string|regex:/^-?\d+\.?\d*,-?\d+\.?\d*$/',
            'radiusMeters' => 'required|numeric|min:0',
        ];
    }
}
