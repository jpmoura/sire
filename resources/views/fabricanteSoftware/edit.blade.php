@extends('layout.base')

@section('title')
    Editar Fabricante de Software
@endsection

@section('page_icon')
    <i class="fa fa-wrench"></i>
@endsection

@section('description')
    Preencha os campos editar um fabricante de software existente.
@endsection

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form class="form" action="{{ route('fabricante.update', $fabricante->id) }}" accept-charset="UTF-8" method="post">
                        {{ method_field('PATCH') }}

                        @include('fabricanteSoftware.form')

                        <br />

                        <div class="text-center">
                            <button type="button" class="btn btn-danger" onClick="history.back()"><i class='fa fa-times'></i> Cancelar</button>
                            <button type="reset" class="btn btn-warning"><i class='fa fa-eraser'></i> Limpar</button>
                            <button type="submit" class="btn btn-success"><i class='fa fa-check'></i> Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
