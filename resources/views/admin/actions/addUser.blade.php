@extends('admin.admin_base')

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>

          @if(Session::has("tipo"))
            <div class="row">
              <div class="text-center alert alert-dismissible @if(Session::get('tipo') == 'Sucesso') alert-success @else alert-danger @endif" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>{{Session::get("tipo")}}!</strong> {{Session::get("mensagem")}}
              </div>
            </div>
          @endif

          <div class="box box-primary-ufop">
            <div class="box-body">
              <form class="form" action="{{url('/usuarios/cadastrar')}}" accept-charset="UTF-8" method="post">
                {{ csrf_field() }}

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" id="cpf" class="form-control" placeholder="CPF do usuário" value="{{Input::old('nome')}}" @if(Session::get("tipo") != "Erro") autofocus @endif name="cpf" required mixlength="11" maxlength="11" data-toggle="tooltip" data-placement="right" title="CPF">
                </div>

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                  <select class="form-control" name="nivel" required data-toggle="tooltip" data-placement="right" title="Nível de privilégio">
                    <option value="">Selecione</option>
                    <option value="1" @if(Input::old('nivel') == 1) selected @endif>Administrador</option>
                    <option value="2" @if(Input::old('nivel') == 2) selected @endif>Professor / Administrativo</option>
                    <option value="3" @if(Input::old('nivel') == 3) selected @endif>Usuário Especial</option>
                  </select>
                </div>

                <input type="hidden" value="" name="nome" required />
                <input type="hidden" value="" name="email" required />
                <input type="hidden" value="0" name="canAdd" required />

                <div id='details' class="row text-center">
                </div>
                <br />

                <div class="text-center">
                  <button type="button" class="btn btn-danger" onClick="history.go(-1)">Cancelar <i class='fa fa-times'></i></button>
                  <button type="reset" class="btn btn-warning">Limpar <i class='fa fa-eraser'></i></button>
                  <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
                </div>
              </form>
            </div>
          </div>
        </div><!-- /.col -->
    </div><!-- /.row -->


    <script type="text/javascript">
      $(function(){
        $('#cpf').blur(function(){
          $("#details").html("<img width='36px' height='36px' alt='Carregando...' src='{{ asset('img/loading.gif') }}'/>"); // ícone mostrando o carregamento da informação
          $.ajax({
            url: '{{url('/searchperson')}}', // url
            type: "post", // método
            data: {'cpf':$('input[name=cpf]').val(), '_token': $('input[name=_token]').val()}, // dados para o método post

            success: function(response){
              $("#details").html("<h3>Detalhes do Usuário</h3>");

              // Se a resposta for OK
              if(response.status == 'success') { // Achou o usuário
                $("#details").append("<i class='fa fa-user'></i> " + response.name + "<br />");
                $("#details").append("<i class='fa fa-envelope'></i> " + response.email + "<br />");
                $("#details").append("<i class='fa fa-users'></i> " + response.group + "<br />");

                //alterar os inputs escondidos
                $('input[name=nome]').val(response.name);
                $('input[name=email]').val(response.email);
                $('input[name=canAdd]').val(1); // significa que pode adicionar

              }
              else { // Não encontrou ninguém
                $("#details").append("<p>" + response.msg + "</p><p>É <span class='text-bold'>necessário</span> que o futuro usuário esteja cadastrado no servidor LDAP.</p><br />");
                $('input[name=nome]').val('');
                $('input[name=email]').val('');
                $('input[name=canAdd]').val(0);
              }
            },

            // Se houver erro na requisição (e.g. 404)
            error: function (XMLHttpRequest, textStatus, errorThrown) {
             $("#details").html(XMLHttpRequest.responseText);
            },

            complete: function(data){
              console.log(data);
            }
          });
        });
      });

    </script>
@endsection
