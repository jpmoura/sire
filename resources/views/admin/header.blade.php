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
            <li>
              <a href="{{url('sair')}}"><i class="fa fa-sign-out"></i> Sair</a>
            </li>
          </ul>
        </div>
    </nav>
</header>
