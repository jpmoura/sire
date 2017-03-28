<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeuIceaUser extends Model
{
    protected $connection = "meuicea";
    protected $table = "usuarios";

    protected $fillable = [
        'cpf', 'nome', 'email', 'id_grupo', 'grupo', 'meuicea_token',
    ];

    protected $hidden = [
        'cpf', 'id_grupo', 'remember_token', 'created_at', 'updated_at', 'meuicea_token',
    ];
}
