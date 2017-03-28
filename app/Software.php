<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nome', 'versao','fabricante_software_id', 'status'
    ];

    public function fabricante()
    {
        return $this->belongsTo('App\FabricanteSoftware', 'fabricante_software_id', 'id');
    }
}
