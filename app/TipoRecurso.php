<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoRecurso extends Model
{
    protected $table = "tipo_recurso";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
    ];

    /**
     * Recupera todos os recursos de um tipo
     */
    public function recursos()
    {
        return $this->hasMany('App\Recurso', 'tipo_recurso_id');
    }
}
