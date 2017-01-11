<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Reserva - Em Manutenção</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    {!! HTML::style('public/css/bootstrap/bootstrap.min.css') !!}
    {!! HTML::style('public/css/font-awesome/font-awesome.min.css') !!}
    {!! HTML::style('public/css/app.css') !!}

    {!! HTML::favicon('public/favicon.ico') !!}
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition login-page skin-ufop guest">
<div class="login-box">
    <div class="login-logo">
        <p class="text-bold"><i class="fa fa-refresh fa-spin fa-2x fa-fw"></i><br />Sistema em Manutenção.</p>
        <p>Por favor<br>volte mais tarde.</p>
    </div>
</div>
<footer class="text-center">
    <!-- Default to the left -->
    <strong>Copyleft <i class="fa fa-creative-commons"></i> {{ date("Y") }} <a href="{{url('/sobre')}}">NTI ICEA</a></strong>.
</footer>
{!! HTML::script('public/js/app.js') !!}
</body>
</html>
