@extends('layout.base')

@section('title')
    Erro 428
@endsection

@section('page_icon')
    <i class="fa fa-times"></i>
@endsection

@section('description')
    Ocorreu um erro do tipo 430
@endsection

@section('content')
    <div class="row">
        <div class="error-page">
            <h2 class="headline text-yellow">430</h2>
            <br />
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Token consumido!</h3>

                <p>
                    O token que você está tentando utilizar já foi usado para autenticar o usuário.
                </p>
            </div>
        </div>
    </div>
@endsection
