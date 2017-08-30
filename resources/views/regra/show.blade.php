@extends('layout.base')

@section('title')
    Consulta de Regras
@endsection

@section('page_icon')
    <i class='fa fa-gears'></i>
@endsection

@section('description')
    Resumo das regras de horários que regem o sistema.
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form>
                        @include('regra.form')
                    </form>
                    <div class="text-center">
                        <a class="btn btn-ufop" href="{{ route('detailsRule', $regras) }}"><i class="fa fa-edit"></i> Editar</a>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
