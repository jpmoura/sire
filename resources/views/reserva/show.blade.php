@extends('layout.base')

@section('title')
    @if(Route::is('showAllocatedAssetBoard'))
        Quadro de Reservas
    @else
        Alocar Recurso
    @endif
@endsection

@section('page_icon')
    @if(Route::is('showAllocatedAssetBoard'))
        <i class="fa fa-calendar-check-o"></i>
    @else
        <i class="fa fa-calendar-plus-o"></i>
    @endif
@endsection

@section('description')
    @if(Route::is('showAllocatedAssetBoard'))
        Esse é o quadro contendo todas as reservas.
    @else
        Selecione os horários em que deseja alocar ou desalocar o recurso.
    @endif
@endsection

@section('content')

    <div class='row'>
        <div class='col-md-10 col-md-offset-1 text-center'>
            <h2>{!! $recurso->nome !!}</h2>
            <br />

            @if(!Route::is('showAllocatedAssetBoard'))
                <form class="form" action="{{ route('storeAllocation') }}" method="post" >
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{ $recurso->id }}" />
            @endif

            @include('reserva.quadro.layout', ['turno' => 'm'])
            @include('reserva.quadro.layout', ['turno' => 'v'])
            @include('reserva.quadro.layout', ['turno' => 'n'])

            @if(!Route::is('showAllocatedAssetBoard'))
                    <div class="text-center">
                        <a href="{{ route('selectAllocation') }}" class="btn btn-ufop" role="button"><i class="fa fa-arrow-left"></i> Voltar</a>
                        <button type="reset" class="btn btn-warning">Limpar <i class='fa fa-eraser'></i></button>
                        <button type="button" class="btn btn-danger" onClick="history.back()">Cancelar <i class='fa fa-times'></i></button>
                        <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
                    </div>
                </form>
            @endif

        </div><!-- /.col -->
    </div><!-- /.row -->

    @if(Route::is('showAllocatedAssetBoard'))
        <div class="row">
            <div class="text-center">
                <button type="button" class="btn btn-warning" onclick="history.back()"><i class="fa fa-arrow-left"></i> Voltar</button>
            </div>
        </div>
    @endif

@endsection
