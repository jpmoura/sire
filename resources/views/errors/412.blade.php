@extends('layout.base')

@section('title')
    Erro 412
@endsection

@section('page_icon')
    <i class="fa fa-times"></i>
@endsection

@section('description')
    Ocorreu um erro do tipo 412
@endsection

@section('content')
    <div class="row">
        <div class="error-page">
            <h2 class="headline text-yellow">412</h2>
            <br />
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Sua Sessão expirou!</h3>

                <p>
                    Você pode fazer o login diretamente no
                    <a href="{{ url('/login') }}"><i class="fa fa-calendar-check-o"></i> Sistema de Reserva</a> ou
                    então realizar o login no portal
                    <a href="http://localhost/meuicea/public/login"><i class="fa fa-building-o"></i> Meu ICEA</a>.
                </p>
            </div>
        </div>
    </div>
@endsection
