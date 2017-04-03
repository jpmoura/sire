@extends('layout.base')

@section('title')
    Lista de Tipos de Recursos
@endsection

@section('page_icon')
    <i class="fa fa-desktop"></i>
@endsection

@section('description')
    Lista de tipos de recursos cadastrados.
@endsection

@push('extra-css')
<link rel="stylesheet" href="{{ url('public/js/plugins/datatables/dataTables.bootstrap.css') }}">
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
            "aaSorting": [[ 0, "asc" ]],
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tudo"]]
        });
    });
</script>
@endpush

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            @if(isset($tipos))
                <div class="box box-primary-ufop">
                    <div class="box-header">
                        <h3 class="box-title">Atualmente existem {{ $tipos->count() }} softwares cadastrados.</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-hover table-striped table-bordered text-center">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tipos as $tipo)
                                    <tr>
                                        <td>{!! $tipo->nome !!}</td>
                                        <td>
                                            <a class="btn btn-ufop btn-xs" href="{{ route('tiporecurso.edit', $tipo->id) }}"><i class="fa fa-edit"></i> Editar</a> ou
                                            <a href="#" class="btn btn-danger btn-xs" onclick="event.preventDefault();document.getElementById('delete-form-{{ $tipo->id }}').submit();"><i class="fa fa-trash"></i> Excluir</a>
                                            <form id="delete-form-{{ $tipo->id }}" action="{{ route('tiporecurso.destroy', $tipo->id) }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Nome</th>
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
