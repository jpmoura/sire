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
                                            <a class="btn btn-ufop btn-xs" href="{{ route('detailsBug', $bug->id) }}"><i class="fa fa-search-plus"></i> Detalhes</a> ou
                                            <a href="#" data-toggle="modal" data-target="#deleteModal" data-id="{{ $bug->id }}" data-title="{!! $bug->titulo !!}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Excluir</a>
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

    <div class="row">
        <div class="modal modal-warning fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center"><i class="fa fa-warning"></i> Atenção</h4>
                    </div>
                    <form class="form text-center" action="{{ route('deleteBug') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" id="formID" name="id" value="">
                        <div class="modal-body">
                            <p id="mensagem" class="text-center"></p>
                            <br />
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
