@extends('layout.base')

@section('title')
    Selecione um recurso
@endsection

@section('page_icon')
    <i class="fa fa-search"></i>
@endsection

@section('description')
    Selecione um recurso.
@endsection

@push('extra-css')
    @if($rota == route('recurso.selected.date'))
        {!! HTML::style('public/js/plugins/datepicker/datepicker3.css') !!}
    @endif
@endpush

@push('extra-js')
    @if($rota == route('recurso.selected.date'))
        {!! HTML::script('public/js/plugins/datepicker/bootstrap-datepicker.js') !!}
        {!! HTML::script('public/js/plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js') !!}
        <script>
            $(function()
            {
                $( "#data" ).datepicker({
                    showWeek: true,
                    daysOfWeekDisabled: [0],
                    todayHighlight: true,
                    todayBtn: true,
                    format: "dd/mm/yyyy",
                    showAnim: "slide",
                    language: 'pt-BR',
                    weekStart: 1,
                    autoclose: true,
                    showOnFocus: true
                });
            });
        </script>
    @endif
@endpush

@section('content')
    <div class='row'>
        <div class='col-md-4 col-md-offset-4 text-center'>
            <div class="box box-primary-ufop">
                @if(!Auth::check())
                    <div class="box-header">
                        Visualizar um quadro de reservas
                    </div>
                @endif
                <div class="box-body">
                    <form class="form" action="{!! $rota !!}" accept-charset="UTF-8" method="get">
                        @include('recurso.select.form')
                    </form>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

