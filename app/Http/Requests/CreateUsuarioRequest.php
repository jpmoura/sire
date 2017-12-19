<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateUsuarioRequest extends Request
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
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nivel'  => 'required|in:1,2,3',
            'nome'   => 'required|max:45',
            'email'  => 'required|unique:usuarios|max:255',
            'password' => 'required|confirmed|max:255',
        ];
    }
}
