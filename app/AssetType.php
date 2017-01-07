<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    //
    protected $table = "tb_tipo";
    protected $primaryKey = "tipoId";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipoNome',
    ];

    /**
     * Recupera todos os recursos de um tipo
     */
    public function assets()
    {
        return $this->hasMany('App\Asset', 'tipoId', 'tipoId');
    }
}
