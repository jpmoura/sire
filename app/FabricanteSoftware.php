<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FabricanteSoftware extends Model
{
    public $timestamps = false;

    protected $fillable =[
        'nome'
    ];

    public function softwares()
    {
        return $this-> hasMany('App\Software');
    }
}
