@extends('layout.base')

@section('title')
    @if(auth()->check())
        Alocar Recurso
    @else
        Quadro de Reservas
    @endif
@endsection

@section('page_icon')
    @if(auth()->check())
        <i class="fa fa-calendar-plus-o"></i>
    @else
        <i class="fa fa-calendar-check-o"></i>
    @endif
@endsection

@section('description')
    @if(auth()->check())
        Selecione os horários em que deseja alocar ou desalocar o recurso.
    @else
        Esse é o quadro contendo todas as reservas.
    @endif
@endsection

@push('extra-js')
    <script>
        function submitForm($id)
        {
            var deleteForm = document.getElementById('delete.form');
            deleteForm.action = deleteForm.action.replace('0', $id);
            deleteForm.submit();
        }
    </script>
@endpush

@section('content')
    <div class='row'>
        <div class='col-md-10 col-md-offset-1 text-center'>
            <h2>{!! $recurso->nome !!}</h2>
            <br />

            @if(auth()->check() && !Route::is('reserva.show.date'))
                <form id="delete.form" class="form-inline" action="{{ route('reserva.destroy', 0) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                </form>

                <form class="form" action="{{ route('reserva.store') }}" method="post" >
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{ $recurso->id }}" />
            @endif

            @include('reserva.quadro.layout', ['turno' => 'm'])
            @include('reserva.quadro.layout', ['turno' => 'v'])
            @include('reserva.quadro.layout', ['turno' => 'n'])

            <div class="text-center">
                <button class="btn btn-ufop" onclick="history.back()"><i class="fa fa-arrow-left"></i> Voltar</button>
                @if(auth()->check() && !Route::is('reserva.show.date'))
                    </form>
                    <button type="reset" class="btn btn-warning">Limpar <i class='fa fa-eraser'></i></button>
                    <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
                @endif
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection
