@extends('layout.base')

@section('title')
    Lista de recursos
@endsection

@section('page_icon')
    <i class="fa fa-th-list"></i>
@endsection

@section('description')
    Esta é a lista com todos os recursos cadastrados no sistema.
@endsection

@push('extra-css')
<link rel="stylesheet" href="{{url('public/js/plugins/datatables/dataTables.bootstrap.css')}}">
@endpush

@push('extra-js')
<script src="{{url('public/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('public/js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
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
            "aaSorting": [[ 1, "asc" ]],
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tudo"]]
        });
    });


    $('#deleteModal').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget); // Button that triggered the modal
        var id = link.data('id'); // Extract info from data-* attributes
        var nome = link.data('nome'); // Extract info from data-* attributes

        document.getElementById("mensagem").innerHTML = 'Você realmente quer excluir o recurso ' + nome + '?';
        document.getElementById("formID").setAttribute("value", id)
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
            @if(!is_null($recursos))
                <div class="box box-primary-ufop">
                    <div class="box-header">
                        <h3 class="box-title">Atualmente existem {{ count($recursos) }} recursos cadastrados</h3>
                    </div>
                    <div class="box-body">
                        <div class="table">
                            <table id="table" class="table table-hover table-striped table-bordered text-center">
                                <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                    <th>Descrição</th>
                                    @can('administrate')
                                        <th>Status</th>
                                        <th>Ações</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recursos as $recurso)
                                    <tr>
                                        <td>{{ $recurso->id }}</td>
                                        <td>{!! $recurso->nome !!}</td>
                                        <td>{!! $recurso->tipo->nome !!}</td>
                                        <td>{!! $recurso->descricao !!}</td>
                                        @can('administrate')
                                            <td>
                                                <b>
                                                    @if($recurso->status == 1)
                                                        <span class="text-success">Ativo</span>
                                                    @else
                                                        <span class="text-warning">Inativo</span>
                                                    @endif
                                                </b>
                                            </td>
                                            <td>
                                                <a class="btn btn-ufop btn-xs" href="{{ route('recurso.edit', $recurso->id) }}"><i class="fa fa-edit"></i> Editar</a>
                                                @if($recurso->status != 0)
                                                    ou
                                                    <form style="display: inline" class="form" action="{{ route('recurso.destroy', $recurso->id) }}" method="post">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button class="btn btn-danger btn-xs" id="excluir_button_{{ $recurso->id }}"><i class="fa fa-trash"></i> Excluir</button>
                                                    </form>
                                                @endif
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                    <th>Descrição</th>
                                    @can('administrate')
                                        <th>Status</th>
                                        <th>Ações</th>
                                    @endcan
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
