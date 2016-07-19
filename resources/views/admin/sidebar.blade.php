<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset("dist/img/default-user.png") }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ Session::get("username") }}</p>
                <!-- Status -->
                <h6><i class="fa fa-circle text-success"></i> Online</h6>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
          @if(Session::get("nivel") == 1)
            <li class="header text-center">ADMINISTRAÇÃO</li>
            <li @if(Session::get("menu") == "regras") class="active" @endif><a href="{{url('/regras')}}"><i class="fa fa-cogs" aria-hidden="true"></i><span>Visualizar Regras</span></a></li>
            <li @if(Session::get("menu") == "addUsuario") class="active" @endif><a href="{{url('/usuarios/cadastrar')}}"><i class="fa fa-user-plus" aria-hidden="true"></i><span>Cadastrar Usuários</span></a></li>
            <li @if(Session::get("menu") == "addRecurso") class="active" @endif><a href="{{url('/recursos/cadastrar')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i><span>Cadastrar Recurso</span></a></li>
            <li @if(Session::get("menu") == "viewUsuario") class="active" @endif><a href="{{url('/usuarios/consulta')}}"><i class="fa fa-users" aria-hidden="true"></i><span>Consultar Usuários</span></a></li>
            <li @if(Session::get("menu") == "viewReserva") class="active" @endif><a href="{{url('/reserva/consulta')}}"><i class="fa fa-search" aria-hidden="true"></i><span>Consultar Reserva</span></a></li>
            <li @if(Session::get("menu") == "ldap") class="active" @endif><a href="{{url('/ldap')}}"><i class="fa fa-server" aria-hidden="true"></i><span>LDAP</span></a></li>
            <li @if(Session::get("menu") == "bug") class="active" @endif><a href="{{url('/bug/visualizar')}}"><i class="fa fa-bug" aria-hidden="true"></i><span>Bugs</span></a></li>
          @endif

          @if(Session::has("id"))
            <li class="header text-center">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <li @if(Session::get("menu") == "quadro") class="active" @endif><a href="{{url('/quadro/visualizar')}}"><i class="fa fa-calendar" aria-hidden="true"></i><span>Quadro de Reservas</span></a></li>
            <li @if(Session::get("menu") == "allocRecurso") class="active" @endif><a href="{{url('/recursos/alocar')}}"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i><span>Alocar Recurso</span></a></li>
            {{-- <li @if(Session::get("menu") == "editUsuario") class="active" @endif><a  href="{{url('/usuarios/editar/')}}"><i class="fa fa-edit" aria-hidden="true"></i><span>Alterar Dados Pessoais</span></a></li> --}}
            <li @if(Session::get("menu") == "viewRecurso") class="active" @endif><a href="{{url('/recursos/consulta')}}"><i class="fa fa-search" aria-hidden="true"></i><span>Consultar Recursos</span></a></li>
            <li @if(Session::get("menu") == "bugForm") class="active" @endif><a href="{{url('/bug/adicionar')}}"><i class="fa fa-bug" aria-hidden="true"></i><span>Reportar Bug</span></a></li>
            <li><a href="{{url('/sair')}}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Sair</span></a></li>
          @endif

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
