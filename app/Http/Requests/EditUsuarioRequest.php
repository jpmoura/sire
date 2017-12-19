<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditUsuarioRequest extends Request
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
            'email'  => 'required|unique:usuarios,email,' . $this->request->get('id') . '|max:255',
            'password' => 'confirmed|max:255',
            'status' => 'required|boolean'
        ];
    }
}
