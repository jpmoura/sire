@extends('admin.admin_base')

@section('content')
    <link rel="stylesheet" href="{{url('plugins/datatables/dataTables.bootstrap.css')}}">

    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>

          @if(Session::has("tipo"))
            <div class="row">
              <div class="text-center alert alert-dismissible @if(Session::get('tipo') == 'Sucesso') alert-success @else alert-danger @endif" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>{{Session::get("tipo")}}!</strong> {!! Session::get("mensagem") !!}
              </div>
            </div>
            <br />
          @endif

          @if(isset($bugs))
            <div class="box box-primary-ufop">
              <div class="box-header">
                <h3 class="box-title">Atualmente existem {{ count($bugs) }} bugs reportados</h3>
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
                          <td>{!! $bug->title !!}</td>
                          <td>{{ $bug->nome }}</td>
                          <td>
                            <a class="btn btn-default btn-xs" href="{{ url('/bug/detalhe/' . $bug->id) }}"><i class="fa fa-search-plus"></i> Detalhes</a> ou
                            <a href="#" data-toggle="modal" data-target="#deleteModal" data-id="{{$bug->id}}" data-title="{{$bug->title}}" class="btn btn-default btn-xs"><i class="fa fa-trash"></i> Excluir</a>
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
              <div class="modal-body">
                <p id="mensagem" class="text-center"></p>
                <br />
                <form class="form text-center" action="{{(url('/bug/deletar'))}}" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" id="formID" name="id" value="">
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar <i class='fa fa-times'></i></button>
                  <button type="submit" class="btn btn-success pull-right">Confirmar <i class='fa fa-check'></i></button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <script src="{{url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{url('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
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
    </div>
@endsection
