@if(Auth::check())
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            <a href="{{ route('about.show') . "#modificacoes" }}">{{ config('app.version') }}</a>
        </div>
        <!-- Default to the left -->
        Copyleft <i class="fa fa-creative-commons"></i> {{ date("Y") }} <a href="{{ route('about.show') }}"><strong>João Pedro Santos de Moura</strong></a>.
    </footer>
@else
    <footer>
        <div class="col-md-8 col-md-offset-2 text-center">
            <hr>
            Copyleft <i class="fa fa-creative-commons"></i> {{ date("Y") }} <a href="{{ route('about.show') . '#modificacoes' }}"><strong>João Pedro Santos de Moura</strong></a>.
            <div class="pull-right hidden-xs">
                <a href="{{url('/sobre#modificacoes')}}">{{ config('app.version') }}</a>
            </div>
        </div>
    </footer>
@endif
