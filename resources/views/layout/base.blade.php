<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>SiRe - @yield('title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link href="{{ asset("public//bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/dist/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("public/dist/css/AdminLTE.min.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("public/dist/css/custom.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("public/dist/css/skins/skin-ufop.css") }}" rel="stylesheet" type="text/css" />

    <link rel="shortcut icon" href="{{ url('public/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('public/favicon.ico') }}" type="image/x-icon">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-ufop hold-transition sidebar-mini @if(!Auth::check()) guest @endif">

@if(Auth::check())
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
            <!-- jQuery 2.2.4 -->
            <script src="{{ asset ('public/plugins/jQuery/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
            @yield('content')
        </section><!-- /.content -->
@if(Auth::check())
    </div><!-- /.content-wrapper -->
@endif

    <!-- Footer -->
    @include('layout.footer')

@if(Auth::check())
    </div><!-- ./wrapper -->
@endif

<script src="{{ asset ('public/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset ('public/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ asset ('public/plugins/fastclick/fastclick.js') }}" type="text/javascript"></script>
<script src="{{ asset ('public/dist/js/app.min.js') }}" type="text/javascript"></script>
