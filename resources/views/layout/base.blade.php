<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>SiRe - @yield('title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    {!! HTML::style('public/css/app.css') !!}
    @stack('extra-css')

    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-ufop hold-transition sidebar-mini @if(!auth()->check()) guest @endif">

@if(auth()->check())
    <div class="wrapper">

        <!-- Header -->
    @include('layout.header')

    <!-- Sidebar -->
    @include('layout.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>@yield('page_icon') @yield('title')
                <small>@yield('description')</small>
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Início</a></li>
                <li>@yield('title')</li>
            </ol>
        </section>
@endif
        <!-- Main content -->
        <section class="content">
            @if(session()->has("tipo"))
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center alert alert-dismissible @if(session('tipo') == 'Sucesso') alert-success @else alert-danger @endif" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>{!! session("tipo") !!}!</strong> {!! session("mensagem") !!}
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </section><!-- /.content -->
@if(auth()->check())
    </div><!-- /.content-wrapper -->
@endif

    <!-- Footer -->
    @include('layout.footer')

@if(auth()->check())
    </div><!-- ./wrapper -->
@endif

{{--{!! HTML::script('resources/assets/js/jQuery/jquery-2.2.4.min.js') !!}--}}
{{--{!! HTML::script('resources/assets/js/bootstrap/bootstrap.min.js') !!}--}}
{{--{!! HTML::script('resources/assets/js/slimScroll/jquery.slimscroll.min.js') !!}--}}
{{--{!! HTML::script('resources/assets/js/fastclick/fastclick.min.js') !!}--}}
{{--{!! HTML::script('resources/assets/js/adminLTE/app.min.js') !!}--}}
{!! HTML::script('public/js/app.js') !!}
@stack('extra-js')