<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'usuario_id', 'recurso_id', 'data', 'horario', 'turno',
    ];

    protected $hidden = [
        'id',
    ];

    /**
     * Recupera o usuário que realizou a alocação.
     */
    public function usuario()
    {
        return $this->belongsTo('App\Usuario');
    }

    /**
     * Recupera o recurso alocado.
     */
    public function recurso()
    {
        return $this->belongsTo('App\Recurso');
    }

    /**
     * @param Query $query Query a ser modificada
     * @param \DateTime $diaInicial Data a partir que as reservas serão procuradas
     * @return mixed Query extendida
     */
    public function scopeIniciandoEm($query, $diaInicial)
    {
        return $query->where('data', '>=', $diaInicial);
    }

    /**
     * @param $query Query a ser modificada
     * @param \DateTime $diaFinal Dia limite o qual as reservas serão recuperadas
     * @return mixed Query extendida
     */
    public function scopeFinalizandoEm($query, $diaFinal)
    {
        return $query->where('data', '<=', $diaFinal);
    }

    /**
     * @param $query Query a ser modificada
     * @param \DateTime $dataEspecifica Data a qual as reservas serão procuradas
     * @return mixed Query extendida
     */
    public function scopeEm($query, $dataEspecifica)
    {
        return $query->where('data', $dataEspecifica);
    }
}
