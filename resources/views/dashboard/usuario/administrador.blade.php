@extends('dashboard.layout')

@section('widgets')
    <div class="col-md-3">
        <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><b>Usuários Frequentes nesse mês</b></span>
                <!-- The progress section is optional -->
                @foreach(array_keys($topUsuariosMesAtual) as $usuario)
                    <span class="progress-description text-left">
                        {!! $usuario !!}: {{ $topUsuariosMesAtual[$usuario] }} reservas
                    </span>
                @endforeach
            </div><!-- /.info-box-content -->
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><b>Usuários Frequentes mês passado</b></span>
                <!-- The progress section is optional -->
                @foreach(array_keys($topUsuariosMesPassado) as $usuario)
                    <span class="progress-description text-left">
                        {!! $usuario !!}: {{ $topUsuariosMesPassado[$usuario] }} reservas
                    </span>
                @endforeach
            </div><!-- /.info-box-content -->
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-cog"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><b>Recursos Frequentes do mês</b></span>
                <!-- The progress section is optional -->
                @foreach(array_keys($topRecursosMesAtual) as $recurso)
                    <span class="progress-description text-left">
                        {!! $recurso !!}: {{ $topRecursosMesAtual[$recurso] }} reservas
                    </span>
                @endforeach
            </div><!-- /.info-box-content -->
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon"><i class="fa fa-cog"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><b>Recurso mais usado mês passado</b></span>
                <!-- The progress section is optional -->
                @foreach(array_keys($topRecursosMesPassado) as $recurso)
                    <span class="progress-description text-left">
                        {!! $recurso !!}: {{ $topRecursosMesPassado[$recurso] }} reservas
                    </span>
                @endforeach
            </div><!-- /.info-box-content -->
        </div>
    </div>
@endsection


@section('info')
    <script src="{{ asset ('public/js/plugins/chartjs/Chart.bundle.min.js') }}" type="text/javascript"></script>

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Reservas nos últimos 6 meses</h3>
            </div>
            <div class="box-body">
                {!! $graficos['reservas']->render() !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Uso dos recursos nos últimos 6 meses</h3>
            </div>
            <div class="box-body estatistica">
                {!! $graficos['recursos']->render() !!}
            </div>
        </div>
    </div>
@endsection