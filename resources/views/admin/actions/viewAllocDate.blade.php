@extends('admin.admin_base')

@section('content')
    <link rel="stylesheet" href="{{url('public/plugins/datepicker/datepicker3.css')}}">
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
          <div class="box box-primary-ufop">
            <div class="box-body">
              <form class="form" action="{{url('/alocacao/consulta')}}" method="post">
                {{csrf_field()}}
                <div class="input-group" >
                  <span class="input-group-addon date"><i class="fa fa-calendar"></i></span>
                  <input maxlength="8" minlength="8" type="text" id="data" name="data" class="form-control" placeholder="Data no formato dd/mm/aa" required>
                </div>

                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                  <select class="form-control" required name="recurso">
                    <option value="">Selecione o recurso</option>
                    @foreach($recursos as $recurso)
                      <option value="{{$recurso->id}}">{{$recurso->nome}}</option>
                    @endforeach
                  </select>
                </div>

                <br />
                <div class="text-center">
                  <button type="button" class="btn btn-warning" onClick="history.back()"><i class='fa fa-arrow-left'></i> Voltar</button>
                  <button type="submit" class="btn btn-primary"><i class='fa fa-search'></i> Visualizar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>

    <script src="{{url('public/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{url('public/plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js')}}"></script>
    <script>
       $(function() {
          $( "#data" ).datepicker({
             showWeek:true,
             daysOfWeekDisabled: [0],
             todayHighlight: true,
             todayBtn: false,
             format: "d/mm/yy",
             showAnim: "slide",
             language: 'pt-BR',
             weekStart: 1,
             autoclose: true,
             showOnFocus: true
          });
       });
    </script>
@endsection
