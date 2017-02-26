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
            'status' => 'required|in:0,1',
        ];
    }
}
