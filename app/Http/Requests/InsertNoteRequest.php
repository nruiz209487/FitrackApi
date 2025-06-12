<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * * Class InsertNoteRequest
 * @package App\Http\Requests
 * la clase InsertNoteRequest se utiliza para validar las solicitudes de inserción de notas.
 */
class InsertNoteRequest extends FormRequest
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
     * reglas para insertar una nota
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
            'header' => 'required|string',
            'text' => 'required|string',
            'userId' => 'required|integer',
            'timestamp' => [
                'required',
                'string',
                'regex:/^(NOTIFICATION:\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}|(\d{4}-\d{2}-\d{2}))$/'
            ],
        ];
    }
}