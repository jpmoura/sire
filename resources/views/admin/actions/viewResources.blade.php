@extends('admin.admin_base')

@section('content')
    <div class='row'>
        <link rel="stylesheet" href="{{url('public/plugins/datatables/dataTables.bootstrap.css')}}">
        <div class='col-md-8 col-md-offset-2'>
          @if(Session::has("tipo"))
            <div class="row">
              <div class="text-center alert alert-dismissible @if(Session::get('tipo') == 'Sucesso') alert-success @else alert-danger @endif" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>{{Session::get("tipo")}}!</strong> {{Session::get("mensagem")}}
              </div>
            </div>
            <br />
          @endif

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
                        <th>Status</th>
                        @if(Session::get("nivel") == 1)
                          <th>Ações</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($recursos as $recurso)
                        <tr>
                          <td>{{$recurso->id}}</td>
                          <td>{{$recurso->nome}}</td>
                          <td>{{$recurso->tipo}}</td>
                          <td>{{$recurso->descricao}}</td>
                          <td>
                            <b>
                            @if($recurso->status == 1)
                              <span class="text-success">Ativo</span>
                            @else
                              <span class="text-warning">Inativo</span>
                            @endif
                            </b>
                          </td>
                          @if(Session::get("nivel") == 1)
                            <td><a class="btn btn-default btn-xs" href="{{url('recursos/editar/' . $recurso->id)}}"><i class="fa fa-edit"></i> Editar</a> ou <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#deleteModal" href="#" data-id="{{$recurso->id}}" data-nome="{{$recurso->nome}}"><i class="fa fa-trash"></i> Excluir</a></td>
                          @endif
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        @if(Session::get("nivel") == 1)
                          <th>Ações</th>
                        @endif
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          @endif
        </div><!-- /.col -->
    </div><!-- /.row -->

    <script src="{{url('public/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('public/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

    <div class="row">
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center">Você tem certeza?</h4>
              </div>
              <div class="modal-body">
                <p id="mensagem" class="text-center"></p>
                <br />
                <form class="form text-center" action="{{(url('/recursos/deletar'))}}" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" id="formID" name="id" value="">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar <i class='fa fa-times'></i></button>
                  <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
                </form>
              </div>
            </div>
          </div>
        </div>


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
            var link = $(event.relatedTarget) // Button that triggered the modal
            var id = link.data('id') // Extract info from data-* attributes
            var nome = link.data('nome') // Extract info from data-* attributes

            document.getElementById("mensagem").innerHTML = 'Você realmente quer excluir o recurso ' + nome + '?'
            document.getElementById("formID").setAttribute("value", id)
          })

          $('#deleteModal').on('hide.bs.modal', function (event) {
            document.getElementById("mensagem").innerHTML = ""
            document.getElementById("formID").setAttribute("value", "")
          })
        </script>
    </div>


@endsection
