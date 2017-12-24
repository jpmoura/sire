@extends('layout.base')

@section('title')
    Detalhes do bug
@endsection

@section('page_icon')
    <i class="fa fa-bug"></i>
@endsection

@section('description')
    Informação detalhada sobre o problema.
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-hover table-striped table-bordered">
                            <tbody>
                            <tr>
                                <th class="text-center">Título</th>
                                <td class="text-left">{!! $bug->titulo !!}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Descrição</th>
                                <td class="text-left">{!! $bug->descricao !!}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Autor</th>
                                <td class="text-left"><a target="_blank" href="mailto:{!! $bug->autor->email !!}?subject=[UFOP-ICEA] Bug no Sistema de Reservas">{!! $bug->autor->nome !!}</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-warning" onClick="history.back()">Voltar <i class='fa fa-arrow-left'></i></button>
                        <form style="display: inline" action="{{ route('bug.destroy', $bug->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button id="excluir_button_{{ $bug->id }}" class="btn btn-danger"><i class="fa fa-trash"></i> Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
