@if(Session::has("id"))
  <footer class="main-footer">
      <!-- To the right -->
      <div class="pull-right hidden-xs">
          <a href="{{url('/sobre#modificacoes')}}">Versão 2.0</a>
      </div>
      <!-- Default to the left -->
      Copyleft <i class="fa fa-creative-commons"></i> {{ date("Y") }} <a href="{{url('/sobre#')}}"><strong>NTI ICEA</strong></a>.
  </footer>
@else
  <footer>
    <div class="col-md-8 col-md-offset-2 text-center">
      <hr>
      Copyleft <i class="fa fa-creative-commons"></i> {{ date("Y") }} <a href="{{url('/sobre#')}}"><strong>NTI ICEA</strong></a>.
      <div class="pull-right hidden-xs">
          <a href="{{url('/sobre#modificacoes')}}">Versão 2.0</a>
      </div>
    </div>
  </footer>
@endif
