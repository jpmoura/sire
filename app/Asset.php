<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    //
    protected $table = "tb_equipamento";
    protected $primaryKey = "equId";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipoId', 'equNome', 'equDescricao', 'equStatus',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'equId',
    ];

    /**
     * Recupera o tipo do recurso.
     */
    public function type()
    {
        return $this->hasOne('App\AssetType', 'tipoId');
    }

    /**
     * Recupera todas as alocações do recurso
     */
    public function allocations()
    {
        return $this->hasMany('App\Allocation', 'equId', 'equId');
    }

}
