<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * Class UpdateUserRequest
 * @package App\Http\Requests
 *
 * La clase UpdateUserRequest se utiliza para validar las solicitudes de actualización de usuarios.
 */
class UpdateUserRequest extends FormRequest
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
     * reglas para actualizar un usuario
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255',
            'password' => 'sometimes|string|min:8',
            'password_confirmation' => 'sometimes|string|min:8',
            'streakDays' => 'sometimes|integer|min:0',
            'lastStreakDay' => 'sometimes|string',
            'profileImage' => 'sometimes|string|nullable',
            'gender' => 'sometimes|string|nullable',
            'height' => 'sometimes|numeric|nullable',
            'weight' => 'sometimes|numeric|nullable',
        ];
    }

}