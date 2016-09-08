<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema de Reserva - Login</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.2 -->
  <link href="{{ asset("/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
  <!-- Font Awesome Icons -->
  <link href="{{asset('dist/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="{{ asset("dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
  page. However, you can choose any other skin. Make sure you
  apply the skin class to the body tag so the changes take effect.
-->
<link href="{{ asset("dist/css/skins/skin-ufop.css")}}" rel="stylesheet" type="text/css" />
<link href="{{ asset("dist/css/custom.css")}}" rel="stylesheet" type="text/css" />

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
      <i class="fa fa-calendar-check-o"></i> <b>Si</b>stema de <b>Re</b>serva de Salas e Equipamentos
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body ufop-border">
      <p class="login-box-msg">Faça o login para gerenciar suas reservas</p>
      <p class="login-box-msg">Use o <span class="text-bold">mesmo CPF</span> e a <span class="text-bold">mesma senha</span><br /> do <a href="http://www.minha.ufop.br/" target="_blank"><i class="fa fa-home"></i>Minha UFOP</a></p>

      <div class="form">
        <form class="form" action="{{url('/login')}}" method="post">
          {{ csrf_field() }}
          <div class="input-group @if(Session::get('erro') == 1) has-error @endif">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" name="login" class="form-control" placeholder="CPF do Minha UFOP (Sem números)" required value="{{Input::old('login')}}" @if(Session::get('erro') != 2)  autofocus @endif data-toggle="tooltip" data-placement="right" title="CPF do Minha UFOP" >
          </div>
          <div class="input-group @if(Session::get('erro') == 2) has-error @endif">
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            <input type="password" name="senha" class="form-control" placeholder="Senha do Minha UFOP" required @if(Session::get('erro') == 2) autofocus @endif data-toggle="tooltip" data-placement="right" title="Senha do Minha UFOP">
          </div>
          @if(Session::has("mensagem"))
            <h5 class="text-center text-danger"><b>{{ Session::get("mensagem") }}</b></h5>
          @endif
          <br />
          <button type="submit" style="background-color: #962038" class="btn btn-primary center-block btn-block"><i class="fa fa-sign-in"></i> Entrar</button>
        </form>
      </div>
      <hr />
      <p class="text-center">Ou clique <a href="{{url('quadro/visualizar')}}"><strong>aqui</strong></a> apenas para visualizar o quadro de reservas.</p>
    </div>
  </div>

  <br />

  <footer class="text-center">
    <!-- Default to the left -->
    <strong>Copyleft <i class="fa fa-creative-commons"></i> {{ date("Y") }} <a href="{{url('/sobre')}}">NTI ICEA</a></strong>.
  </footer>
  <!-- jQuery 2.1.3 -->
  <script src="{{ asset ('plugins/jQuery/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="{{ asset ('bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
  <!-- SlimScroll -->
  <script src="{{ asset ('plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
  <!-- FastClick -->
  <script src="{{ asset ('plugins/fastclick/fastclick.js') }}" type="text/javascript"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset ('dist/js/app.min.js') }}" type="text/javascript"></script>
</body>
</html>
