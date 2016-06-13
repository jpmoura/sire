@extends('admin.admin_base')

@section('content')
    <link rel="stylesheet" href="{{url('plugins/datatables/dataTables.bootstrap.css')}}">

    <div class='row'>
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

          @if(isset($usuarios))
            <div class="box box-primary-ufop">
              <div class="box-header">
                <h3 class="box-title">Atualmente existem {{ count($usuarios) }} usuários cadastrados</h3>
              </div>
              <div class="box-body">
                <div class="table">
                  <table id="table" class="table table-hover table-striped table-bordered text-center">
                    <thead>
                      <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Login</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Celular</th>
                        @if(Session::get("nivel") == 1)
                          <th>Ações</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($usuarios as $usuario)
                        <tr>
                          <td>{{$usuario->id or "Sem ID"}}</td>
                          <td>{!!$usuario->nome or "Sem nome" !!}</td>
                          <td>{{$usuario->login or "Sem login"}}</td>
                          <td>{{$usuario->email or "Sem e-mail"}}</td>
                          <td>{{$usuario->telefone or "Sem telefone"}}</td>
                          <td>{{$usuario->celular or "Sem celular"}}</td>
                          @if(Session::get("nivel") == 1)
                            <td><a class="btn btn-default btn-xs" href="{{url('usuarios/editar/' . $usuario->id)}}"><i class="fa fa-edit"></i> Editar</a> ou <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#deleteModal" href="#" data-id="{{$usuario->id}}" data-nome="{!!$usuario->nome!!}" data-login="{{$usuario->login}}"><i class="fa fa-trash"></i> Excluir</a></td>
                          @endif
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Login</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Celular</th>
                        @if(Session::get("nivel") == 1)
                          <th>Ações</th>
                        @endif
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
                <form class="form text-center" action="{{(url('/usuarios/deletar'))}}" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" id="formID" name="id" value="">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar <i class='fa fa-times'></i></button>
                  <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
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
                            "aaSorting": [[ 1, "asc" ]],
                            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tudo"]]
                          });
            });

          $('#deleteModal').on('show.bs.modal', function (event) {
            var link = $(event.relatedTarget) // Button that triggered the modal
            var id = link.data('id') // Extract info from data-* attributes
            var nome = link.data('nome') // Extract info from data-* attributes
            var login = link.data('login') // Extract info from data-* attributes

            document.getElementById("mensagem").innerHTML = 'Você realmente quer excluir o usuario ' + nome + ' de login ' + login + '?'
            document.getElementById("formID").setAttribute("value", id)
          });

          $('#deleteModal').on('hide.bs.modal', function (event) {
            document.getElementById("mensagem").innerHTML = ""
            document.getElementById("formID").setAttribute("value", "")
          });
        </script>
    </div>
@endsection
