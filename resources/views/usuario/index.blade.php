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
                                        <td><a target="_blank" href="mailto:{{$usuario->email}}?subject=Contato via Sistema de Reserva">{{$usuario->email}}</a></td>
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
                                            <td>
                                                <form class="form-inline" action="{{ route('usuario.destroy', $usuario) }}" method="post">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <a class="btn btn-ufop btn-xs" href="{{ route('usuario.edit', $usuario->id) }}"> <i class="fa fa-edit"></i> Editar</a>
                                                    @if($usuario->status != 0 && $usuario->id != auth()->id())
                                                        ou <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash"></i> Excluir</button>
                                                    @endif
                                                </form>
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
@endsection
