@extends('layout.base')

@section('title')
    Erro 413
@endsection

@section('page_icon')
    <i class="fa fa-times"></i>
@endsection

@section('description')
    Ocorreu um erro do tipo 413
@endsection

@section('content')
    <div class="row">
        <div class="error-page">
            <h2 class="headline text-yellow">413</h2>
            <br />
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Requisição muito grande!</h3>

                <p>
                    Esse erro aconteceu porque o conteúdo da sua requisição é muito grande para ser decodificado.
                    Isso pode ser um erro do seu navegador que pode estar enviando mais informação que o necessário.
                </p>
            </div>
        </div>
    </div>
@endsection
