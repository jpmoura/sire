@extends('admin.admin_base')

@section('content')
  <div class='row'>
    <div class='col-md-8 col-md-offset-2'>
      <div class="box box-primary-ufop">
        <div class="box-body">
          <div class="table-responsive">
            <table class="table text-center table-bordered table-striped table-hover">
              <tr>
                <th>Servidor</th>
                <th>Usuário</th>
                <th>Domínio</th>
                <th>Senha</th>
                <th>Ação</th>
              </tr>
              <tr class="text-center">
                <td>{{$ldap->server}}</td>
                <td>{{$ldap->user}}</td>
                <td>{{$ldap->domain}}</td>
                <td>Ocultada por segurança</td>
                <td><a class="btn btn-default btn-xs" href="{{url('/ldap/editar/')}}"><i class="fa fa-edit"></i> Editar</a></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
