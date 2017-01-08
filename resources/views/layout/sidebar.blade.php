<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @can('administrate')
                <li class="header text-center">ADMINISTRAÇÃO</li>
                <li @if(Route::is('showRule') || Route::is('detailsRule')) class="active" @endif><a href="{{ route('showRule') }}"><i class="fa fa-cogs" aria-hidden="true"></i><span>Visualizar Regras</span></a></li>
                <li @if(Route::is("addUser")) class="active" @endif><a href="{{ route('addUser') }}"><i class="fa fa-user-plus" aria-hidden="true"></i><span>Cadastrar Usuários</span></a></li>
                <li @if(Route::is("addAsset")) class="active" @endif><a href="{{ route('addAsset') }}"><i class="fa fa-plus-circle" aria-hidden="true"></i><span>Cadastrar Recurso</span></a></li>
                <li @if(Route::is("showUser") || Route::is('detailsUser')) class="active" @endif><a href="{{ route('showUser') }}"><i class="fa fa-users" aria-hidden="true"></i><span>Consultar Usuários</span></a></li>
                <li @if(Route::is('selectDetailsAllocation') || Route::is('detailsAllocation')) class="active" @endif><a href="{{ route('detailsAllocation') }}"><i class="fa fa-search" aria-hidden="true"></i><span>Consultar Reserva</span></a></li>
                <li @if(Route::is("showBug") || Route::is('detailsBug')) class="active" @endif><a href="{{ route('showBug') }}"><i class="fa fa-bug" aria-hidden="true"></i><span>Bugs</span></a></li>
                <li><a href="{{ route('showLogs') }}"><i class="fa fa-database" aria-hidden="true"></i><span>Logs</span></a></li>
            @endcan

            @if(Auth::check())
                <li class="header text-center">MENU</li>
                <li @if(Route::is("addAllocation") || Route::is('selectAllocation')) class="active" @endif><a href="{{ route('selectAllocation') }}"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i><span>Alocar Recurso</span></a></li>
                <li @if(Route::is("showAsset") || Route::is('detailsAsset')) class="active" @endif><a href="{{ route('showAsset') }}"><i class="fa fa-search" aria-hidden="true"></i><span>Consultar Recursos</span></a></li>
                <li @if(Route::is("addBug")) class="active" @endif><a href="{{ route('addBug') }}"><i class="fa fa-bug" aria-hidden="true"></i><span>Reportar Bug</span></a></li>
                <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Sair</span></a></li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
</aside>