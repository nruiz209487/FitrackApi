<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * Class InsertUserRequest
 * @package App\Http\Requests
 *
 * La clase InsertUserRequest se utiliza para validar las solicitudes de inserción de usuarios.
 */
class InsertUserRequest extends FormRequest
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
     * reglas para insertar un usuario
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email',
            'password'      => 'required|string|min:8|confirmed',
            'streakDays'    => 'nullable|integer|min:0',
            'profileImage'  => 'nullable|string|max:255',
            'lastStreakDay' => 'nullable|string',
            'gender'        => 'nullable|string',
            'height'        => 'nullable|numeric',
            'weight'        => 'nullable|numeric',
        ];
    }
}
 
