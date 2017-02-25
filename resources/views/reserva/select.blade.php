@extends('layout.base')

@section('title')
    Visualizar quadro de reservas
@endsection

@section('page_icon')
    <i class="fa fa-search"></i>
@endsection

@section('description')
    Selecione um recurso.
@endsection

@push('extra-css')
    @if(Route::is('selectDetailsAllocation'))
        {!! HTML::style('public/js/plugins/datepicker/datepicker3.css') !!}
    @endif
@endpush

@push('extra-js')
    @if(Route::is('selectDetailsAllocation'))
        {!! HTML::script('public/js/plugins/datepicker/bootstrap-datepicker.js') !!}
        {!! HTML::script('public/js/plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js') !!}
        <script>
            $(function()
            {
                $( "#data" ).datepicker({
                    showWeek: true,
                    daysOfWeekDisabled: [0],
                    todayHighlight: true,
                    todayBtn: false,
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
                    <form class="form"
                          action="@if(Route::is('selectAllocation')){{ route('addAllocation') }}@elseif(Route::is('selectDetailsAllocation')){{ route('detailsAllocation') }}@else{{ route('showAllocatedAssetBoard') }}@endif"
                          accept-charset="UTF-8"
                          method="post">

                        {{csrf_field()}}

                        @if(Route::is('selectDetailsAllocation'))
                            <div class="input-group" >
                                <span class="input-group-addon date"><i class="fa fa-calendar"></i></span>
                                <input maxlength="8" minlength="8" type="text" id="data" name="data" class="form-control" placeholder="Data no formato dd/mm/aaaa" required>
                            </div>
                        @endif

                        <select class="form-control" required name="recurso">
                            <option value="">Selecione</option>
                            @foreach($recursos as $recurso)
                                <option value="{{ $recurso->id }}">{!! $recurso->nome !!}</option>
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

