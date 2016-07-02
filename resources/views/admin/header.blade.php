<!-- Main Header -->
<header class="main-header">

    {{-- <!-- Logo -->
    <a href="{{url('/')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SRSE</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>S</b>i<b>R</b>e<b>SE</b></span>
    </a> --}}

    <a href="{{url('/')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>i<b>R</b>e</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Si</b>stema de <b>Re</b>servas</span>
   </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Exibir/Esconder Menu</span>
        </a>

        {{-- <span class="marca-navbar">UNIVERSIDADE FEDERAL DE OURO PRETO</span> --}}

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ asset("dist/img/default-user.png") }}" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{Session::get("nome")}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ asset("dist/img/default-user.png") }}" class="img-circle" alt="User Image" />
                            <p>
                                {{Session::get("nome")}}
                                <small>
                                  @if(Session::get("nivel") == 1)
                                    Administrador
                                  @else
                                    Professor
                                  @endif
                                </small>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer guest">
                            <div class="pull-left">
                                <a class="btn btn-default text-black" href="{{url('usuarios/editar')}}"><i class="fa fa-user"></i> Meus Dados</a>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-default text-black" href="{{url('/sair')}}"><i class="fa fa-sign-out"></i> Sair</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
