@extends('layout.base')

@section('title')
    Usuários Cadastrados
@endsection

@section('page_icon')
    <i class="fa fa-users"></i>
@endsection

@section('description')
    Lista com todos os usuários cadastrados no sistema.
@endsection

@push('extra-css')
{!! HTML::style('public/js/plugins/datatables/dataTables.bootstrap.css') !!}
@endpush

@push('extra-js')
{{--{!! HTML::script('public/js/plugins/datatables/datatables.min.js') !!}--}}
{!! HTML::script('public/js/plugins/datatables/jquery.dataTables.min.js') !!}
{!! HTML::script('public/js/plugins/datatables/dataTables.bootstrap.min.js') !!}

<script>
    $(function () {
        $("#table").DataTable( {
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nada encontrado.",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(Filtrado de _MAX_ registros)",
                "search": "Procurar:",
                "paginate": {
                    "next": "Próximo",
                    "previous": "Anterior"
                }
            },
            "autoWidth" : true,
            "aaSorting": [[ 0, "asc" ]],
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tudo"]]
        });
    });

    $('#deleteModal').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget); // Button that triggered the modal
        var cpf = link.data('cpf'); // Extract info from data-* attributes
        var nome = link.data('nome'); // Extract info from data-* attributes

        document.getElementById("mensagem").innerHTML = 'Você realmente quer excluir o usuario ' + nome + '?';
        document.getElementById("formID").setAttribute("value", cpf)
    });

    $('#deleteModal').on('hide.bs.modal', function (event) {
        document.getElementById("mensagem").innerHTML = "";
        document.getElementById("formID").setAttribute("value", "")
    });
</script>
@endpush

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            @if(isset($usuarios))
                <div class="box box-primary-ufop">
                    <div class="box-header">
                        <h3 class="box-title">Atualmente existem {{ count($usuarios) }} usuários cadastrados</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-hover table-striped table-bordered text-center">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Nível</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($usuarios as $usuario)
                                    <tr>
                                        <td>{!!$usuario->nome !!}</td>
                                        <td><a target="_blank" href="mailto:{{$usuario->email}}?subject=[UFOP-ICEA] Contato via Sistema de Reserva">{{$usuario->email}}</a></td>
                                        <td>
                                            @if($usuario->nivel == 1)
                                                Administrador
                                            @elseif($usuario->nivel == 2)
                                                Professor / Administrativo
                                            @else
                                                Usuário Especial
                                            @endif
                                        </td>
                                        <td>
                            <span class=
                                  @if($usuario->status == 1)
                                          "text-success text-bold">Ativo
                                @else
                                    "text-warning text-bold">Inativo
                                @endif
                            </span>
                                        </td>
                                        @can('administrate')
                                            <td><a class="btn btn-ufop btn-xs" href="{{ route('detailsUser', $usuario->cpf) }}"><i class="fa fa-edit"></i> Editar</a>
                                                @if($usuario->status != 0)
                                                    ou <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteModal" href="#" data-cpf="{!! $usuario->cpf !!}" data-nome="{!! $usuario->nome !!}"><i class="fa fa-trash"></i> Excluir</a>
                                                @endif
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Nível</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div> {{-- fim table-responsive --}}
                    </div> {{-- fim box-body --}}
                </div> {{-- fim box --}}
            @endif
        </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="row">
        <div class="modal modal-warning fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center"><i class="fa fa-warning"></i> Atenção</h4>
                    </div>
                    <form class="form text-center" action="{{ route('deleteUser') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" id="formID" name="cpf" value="{!! $usuario->cpf !!}">
                        <div class="modal-body">
                            <p id="mensagem" class="text-center"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar <i class='fa fa-times'></i></button>
                            <button type="submit" class="btn btn-success pull-right">Confirmar <i class='fa fa-check'></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
