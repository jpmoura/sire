@extends('admin.admin_base')

@section('content')
    <div class='row'>
        <div class='col-md-4 col-md-offset-4 text-center'>
          <div class="box box-primary-ufop">
            <div class="box-body">
              <form class="form" action="{{url('/recursos/alocar')}}" method="post">
                {{csrf_field()}}
                <select class="form-control" required name="recurso">
                  <option value="">Selecione</option>
                  @foreach($recursos as $recurso)
                    <option value="{{$recurso->id}}">{{$recurso->tipo}} - {{$recurso->nome}}</option>
                  @endforeach
                </select>
                <br />
                <div class="text-center">
                  <button type="button" class="btn btn-warning" onClick="history.back()"><i class='fa fa-arrow-left'></i> Voltar</button>
                  <button type="submit" class="btn btn-primary"><i class='fa fa-search'></i> Visualizar</button>
                </div>
              </form>
            </div>
          </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
