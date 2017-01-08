<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    protected $table = 'tb_alocacao';
    protected $primaryKey = 'aloId';
    public $timestamps = false;

    protected $fillable = [
        'usuId', 'equId', 'aloData', 'aloAula',
    ];

    protected $hidden = [
        'aloId',
    ];

    /**
     * Recupera o usuário que realizou a alocação.
     */
    public function user()
    {
        return $this->hasOne('App\User', 'cpf', 'usuId');
    }

    /**
     * Recupera o recurso alocado.
     */
    public function asset() {
        return $this->hasOne('App\Asset', 'equId', 'equId');
    }
}