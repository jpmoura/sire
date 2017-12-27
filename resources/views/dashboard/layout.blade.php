@extends('layout.base')

@section('title')
    Painel de Controle
@endsection

@section('page_icon')
    <i class="fa fa-home"></i>
@endsection

@section('description')
    Bem vindo {{ auth()->user()->nome }}
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-12 text-center'>
            <h3 class="text-center">
                @if(date("G") > -1 && date("G") < 12)
                    Bom dia
                @elseif(date("G") > 11 && date("G") < 18)
                    Boa tarde
                @else
                    Boa noite
                @endif
                <?php setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf8", "portuguese"); ?>
                {{ auth()->user()->nome }}, hoje é {!! utf8_encode(ucfirst(strftime("%A", \Carbon\Carbon::now()->timestamp))) !!}, {{ date("d") }} de {!! ucfirst(strftime("%B", \Carbon\Carbon::now()->timestamp)) !!} de {{ date("Y") }}.</h3>
            <br />
        </div>
    </div>

    <div class="row">
        @yield('widgets')
    </div>

    <div class="row">
        @yield('info')
    </div>
@endsection