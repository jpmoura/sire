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
            'quantidade_horarios_matutino'      => 'required|min:0',
            'horario_inicio_matutino'           => 'required|date_format:H:i:s',
            'quantidade_horarios_vespertino'    => 'required|min:0',
            'horario_inicio_vespertino'         => 'required|date_format:H:i:s',
            'quantidade_horarios_noturno'       => 'required|min:0',
            'horario_inicio_noturno'            => 'required|date_format:H:i:s',
            'quantidade_dias_reservaveis'       => 'required|min:0',
            'quantidade_horarios_seguidos'      => 'required|min:0',
            'tempo_duracao_horario'             => 'required|date_format:H:i:s',
            'intervalo_entre_horarios_seguidos' => 'required|min:0'
        ];
    }
}
