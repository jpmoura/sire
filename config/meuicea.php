<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Chave Meu ICEA
    |--------------------------------------------------------------------------
    |
    | Chave ussada para criptografia dos dados no servidor do Meu ICEA para
    | realização do login automático.
    |
    */

    'chave' => env('MEU_ICEA_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Algoritmo do Meu ICEA
    |--------------------------------------------------------------------------
    |
    | Algoritmo usado na criptografia dos dados no Meu ICEA
    |
    */

    'algoritmo' => env('MEU_ICEA_ALGORITHM'),

];