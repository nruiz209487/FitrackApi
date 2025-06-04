<?php


// InsertNoteRequest corregido
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertNoteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'header'     => 'required|string|max:255',
            'text'       => 'required|string',
            'timestamp'  => 'required|date',
        ];
    }
}