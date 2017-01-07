@extends('layout.base')

@section('title')
    Erro 404
@endsection

@section('page_icon')
    <i class="fa fa-times"></i>
@endsection

@section('description')
    Ocorreu um erro do tipo 404
@endsection

@section('content')
    <div class="row">
        <div class="error-page">
            <h2 class="headline text-yellow">404</h2>
            <br />
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Opa! Página não encontrada.</h3>

                <p>
                    A página que você requisitou não existe.
                    Você pode voltar para a página <a href="{{url('/')}}">inicial</a> ou voltar para a página <a href="javascript:history.back()">anterior</a> em que você estava.
                </p>
            </div>
        </div>
    </div>
@endsection
