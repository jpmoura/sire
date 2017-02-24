<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'descricao', 'status', 'tipo_recurso_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * Recupera o tipo do recurso.
     */
    public function tipo()
    {
        return $this->belongsTo('App\TipoRecurso', 'tipo_recurso_id');
    }

    /**
     * Recupera todas as reservas do recurso
     */
    public function reservas()
    {
        return $this->hasMany('App\Reserva');
    }

}
