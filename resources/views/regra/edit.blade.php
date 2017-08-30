@extends('layout.base')

@section('title')
    Edição de Regras
@endsection

@section('page_icon')
    <i class='fa fa-gears'></i>
@endsection

@section('description')
    Edite a quantidade de horários por turno e a quantidade de dias disponíveis para reserva.
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form class="form" action="{{ route('editRule', $regras) }}" accept-charset="UTF-8" method="post">

                        @include('regra.form')

                        <br />

                        <div class="text-center">
                            <button type="button" class="btn btn-danger" onClick="history.back()">Cancelar <i class='fa fa-times'></i></button>
                            <button type="reset" class="btn btn-warning">Limpar <i class='fa fa-eraser'></i></button>
                            <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
