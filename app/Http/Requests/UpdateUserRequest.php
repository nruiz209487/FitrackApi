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
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
            'password'      => 'required|string|min:8|confirmed',
            'streak_days'   => 'nullable|integer|min:0',
            'profile_image' => 'nullable|string|max:255',
        ];
    }
}
