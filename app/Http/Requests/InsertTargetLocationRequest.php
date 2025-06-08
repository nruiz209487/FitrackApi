<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertTargetLocationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
                'name' => 'required|string|max:255',
                'position' => 'required|string|regex:/^-?\d+\.?\d*,-?\d+\.?\d*$/', // formato: "lat,lng"
                'radiusMeters' => 'required|numeric|min:0',
        ];
    }
}
