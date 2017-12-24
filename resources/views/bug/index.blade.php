@extends('layout.base')

@section('title')
    Lista de bugs
@endsection

@section('page_icon')
    <i class="fa fa-bug"></i>
@endsection

@section('description')
    Lista de todos os problemas já reportados.
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

    $('#deleteModal').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget); // Button that triggered the modal
        var id = link.data('id'); // Extract info from data-* attributes
        var title = link.data('title'); // Extract info from data-* attributes

        document.getElementById("mensagem").innerHTML = 'Você realmente quer excluir o bug de titulo ' + title + '?';
        document.getElementById("formID").setAttribute("value", id);
    });

    $('#deleteModal').on('hide.bs.modal', function (event) {
        document.getElementById("mensagem").innerHTML = "";
        document.getElementById("formID").setAttribute("value", "");
    });
</script>
@endpush

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            @if(isset($bugs))
                <div class="box box-primary-ufop">
                    <div class="box-header">
                        <h3 class="box-title">Atualmente existem {{ $bugs->count() }} bugs reportados</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="table" class="table table-hover table-striped table-bordered text-center">
                                <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Autor</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bugs as $bug)
                                    <tr>
                                        <td>{!! $bug->titulo !!}</td>
                                        <td>{!! $bug->autor->nome !!}</td>
                                        <td>

                                            <form class="form-inline" action="{{ route('bug.destroy', $bug->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <a class="btn btn-ufop btn-xs" href="{{ route('bug.show', $bug->id) }}"><i class="fa fa-search-plus"></i> Detalhes</a> ou
                                                <button id="excluir_button_{{ $bug->id }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Título</th>
                                    <th>Autor</th>
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
