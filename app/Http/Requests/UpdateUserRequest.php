<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'gender' => 'sometimes|in:Hombre,Mujer,Otro',
            'height' => 'sometimes|numeric|min:0|max:3',
            'weight' => 'sometimes|numeric|min:0|max:500',
        ];
    }

}