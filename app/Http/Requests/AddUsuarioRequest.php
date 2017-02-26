<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddUsuarioRequest extends Request
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
            'cpf'    => 'required|min:11|max:14',
            'nivel'  => 'required|in:1,2,3',
            'nome'   => 'required|max:45',
            'email'  => 'required|max:45',
            'canAdd' => 'required|in:1'
        ];
    }
}
