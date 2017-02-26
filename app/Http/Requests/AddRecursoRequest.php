<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddRecursoRequest extends Request
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
            'tipo'      => 'required|exists:tipo_recurso,id',
            'nome'      => 'required|max:50',
            'descricao' => 'required|max:100',
            'status'    => 'required|in:0,1',
        ];
    }
}
