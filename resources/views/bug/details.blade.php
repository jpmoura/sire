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
                                <td class="text-left">{{$bug->title}}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Descrição</th>
                                <td class="text-left">{{$bug->description}}</td>
                            </tr>
                            <tr>
                                <th class="text-center">Autor</th>
                                <td class="text-left"><a target="_blank" href="mailto:{{$bug->email}}?subject=[UFOP-ICEA] Bug no Sistema de Reservas">{{$bug->nome}}</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-warning" onClick="history.back()">Voltar <i class='fa fa-arrow-left'></i></button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Excluir <i class='fa fa-trash'></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-warning fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center"><i class="fa fa-warning"></i> Atenção</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">Você tem certeza que quer excluir esse bug?</p>
                    <br />
                    <form class="form text-center" action="{{ route('deleteBug') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$bug->id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar <i class='fa fa-times'></i></button>
                    <button type="submit" class="btn btn-success pull-right">Confirmar <i class='fa fa-check'></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
