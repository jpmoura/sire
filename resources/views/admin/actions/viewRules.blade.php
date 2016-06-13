@extends('admin.admin_base')

@section('content')
    <div class='row'>
        <div class='col-md-6 col-md-offset-3'>
          <div class="box box-primary-ufop">
            <div class="box-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                  <tr>
                    <th class="text-center">Horários Matutinos</th>
                    <th class="text-center">Horários Vespertinos</th>
                    <th class="text-center">Horários Noturnos</th>
                    <th class="text-center">Dias disponíveis para reserva</th>
                    <th class="text-center">Ações</th>
                  </tr>
                  <tr class="text-center">
                    <td>{{$regras->manha}}</td>
                    <td>{{$regras->tarde}}</td>
                    <td>{{$regras->noite}}</td>
                    <td>{{$regras->dias}}</td>
                    <td><a class="btn btn-default btn-xs" href="{{url('/regras/editar/' . $regras->id)}}"><i class="fa fa-edit"></i> Editar</a></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
