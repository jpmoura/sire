<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'titulo', 'descricao', 'usuario_id'
    ];

    /**
     * Recupera o autor da instância do bug
     */
    public function autor()
    {
        return $this->belongsTo('App\Usuario');
    }
}
