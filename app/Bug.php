<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
    //
    protected $table = 'bugs';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'title', 'description', 'user'
    ];

    /**
     * Recupera o autor da instância do bug
     */
    public function author()
    {
        return $this->hasOne('App\User', 'cpf', 'user');
    }
}
