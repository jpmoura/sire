<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditRegraRequest extends Request
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
            'id'          => 'required',
            'manha'       => 'required|min:0|max:6',
            'inicioManha' => 'required|date_format:H:i:s',
            'tarde'       => 'required|min:0|max:5',
            'inicioTarde' => 'required|date_format:H:i:s',
            'noite'       => 'required|min:0|max:4',
            'inicioNoite' => 'required|date_format:H:i:s',
            'dias'        => 'required|min:1'
        ];
    }
}
