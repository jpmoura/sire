<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditTipoRecursoRequest extends Request
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
            'nome' => 'required|string|max:20|unique:tipo_recurso,nome,' . explode('/' , $this->path())[1],
        ];
    }
}
