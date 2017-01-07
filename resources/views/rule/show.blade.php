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
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <tr>
                                <th class="text-center">Horários Matutinos</th>
                                <th class="text-center">Horários Vespertinos</th>
                                <th class="text-center">Horários Noturnos</th>
                                <th class="text-center">Dias disponíveis para reserva</th>
                                <th class="text-center">Ações</th>
                            </tr>
                            <tr class="text-center">
                                <td>{{ $regras->manha }}</td>
                                <td>{{ $regras->tarde }}</td>
                                <td>{{ $regras->noite }}</td>
                                <td>{{ $regras->dias }}</td>
                                <td><a class="btn btn-default btn-xs" href="{{ route('detailsRule') }}"><i class="fa fa-edit"></i> Editar</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
