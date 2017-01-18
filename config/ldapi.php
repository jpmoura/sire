<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Usuário do LDAPI
    |--------------------------------------------------------------------------
    |
    | Usuário do LDAPI fornecido pelo NTI/ICEA para essa aplicação
    |
    */

    'user' => env('LDAPI_USER'),

    /*
    |--------------------------------------------------------------------------
    | Senha do LDAPI
    |--------------------------------------------------------------------------
    |
    | Senha do usuário do LDAPI fornecido pelo NTI/ICEA para essa aplicação
    |
    */

    'password' => env('LDAPI_PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | Método da Requisição
    |--------------------------------------------------------------------------
    |
    | Método HTTP da requisição usada. Verifique com o responsável pela API
    | qual é o método que é utilizado pela mesma.
    |
    | Normalmente o método é GET ou POST.
    |
    */
    'requestMethod' => env('LDAPI_REQUEST_METHOD'),


    /*
    |--------------------------------------------------------------------------
    | URL de Autenticação
    |--------------------------------------------------------------------------
    |
    | URL para qual serão enviados os dados de autenticação do usuário.
    | Verifique com o responsável pela API qual é a URL.
    |
    */

    'authUrl' => env('LDAPI_AUTH_URL'),

    /*
    |--------------------------------------------------------------------------
    | URL de Busca
    |--------------------------------------------------------------------------
    |
    | URL para qual serão enviados as requisições de busca de usuário para
    | adição dos mesmos.
    |
    */

    'searchUrl' => env('LDAPI_SEARCH_URL'),

];