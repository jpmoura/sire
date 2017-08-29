<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @can('administrate')
                <li class="header text-center">ADMINISTRAÇÃO</li>
                <li @if(Route::is('showRule') || Route::is('detailsRule')) class="active" @endif><a href="{{ route('showRule') }}"><i class="fa fa-cogs" aria-hidden="true"></i><span>Visualizar Regras</span></a></li>
                <li @if(Route::is('selectDetailsAllocation') || Route::is('detailsAllocation')) class="active" @endif><a href="{{ route('detailsAllocation') }}"><i class="fa fa-search" aria-hidden="true"></i><span>Consultar Reserva</span></a></li>

                <li class="treeview {!! Route::is('tiporecurso.index') || Route::is('tiporecurso.create') || Route::is('tiporecurso.edit') || Route::is('addAsset') ? "active" : '' !!}">
                    <a href="#">
                        <i class="fa fa-gear"></i><span>Recursos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li @if(Route::is("addAsset")) class="active" @endif><a href="{{ route('addAsset') }}"><i class="fa fa-plus-circle" aria-hidden="true"></i><span>Adicionar Recurso</span></a></li>
                        <li {!! Route::is('tiporecurso.index') ? "class='active'" : '' !!}><a href="{{ route('tiporecurso.index') }}"><i class="fa fa-th-list"></i> Listar Tipos</a></li>
                        <li {!! Route::is('tiporecurso.create') ? "class='active'" : '' !!}><a href="{{ route('tiporecurso.create') }}"><i class="fa fa-plus-circle"></i> Adicionar Tipo</a></li>
                    </ul>
                </li>

                <li class="treeview {!! Route::is('fabricante.index') || Route::is('fabricante.create') || Route::is('software.create') || Route::is('fabricante.edit') ? "active" : '' !!}">
                    <a href="#">
                        <i class="fa fa-desktop"></i><span>Softwares</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li {!! Route::is('software.create') ? "class='active'" : '' !!}><a href="{{ route('software.create') }}"><i class="fa fa-plus-circle"></i> Adicionar Software</a></li>

                        <li class="treeview {{ Route::is('fabricante.index') || Route::is('fabricante.create') ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-wrench"></i> Fabricantes<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li {!! Route::is('fabricante.index') ? "class='active'" : '' !!}><a href="{{ route('fabricante.index') }}"><i class="fa fa-th-list"></i> Listar</a></li>
                                <li {!! Route::is('fabricante.create') ? "class='active'" : '' !!}><a href="{{ route('fabricante.create') }}"><i class="fa fa-plus-circle"></i> Adicionar</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="treeview {{ Route::is('addUser') || Route::is('showUser') || Route::is('detailsUser') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-users"></i><span>Usuários</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li @if(Route::is("addUser")) class="active" @endif><a href="{{ route('addUser') }}"><i class="fa fa-user-plus" aria-hidden="true"></i><span>Cadastrar Usuário</span></a></li>
                        <li @if(Route::is("showUser")) class="active" @endif><a href="{{ route('showUser') }}"><i class="fa fa-th-list" aria-hidden="true"></i><span>Listar Usuários</span></a></li>
                    </ul>
                </li>

                <li @if(Route::is("showBug") || Route::is('detailsBug')) class="active" @endif><a href="{{ route('showBug') }}"><i class="fa fa-bug" aria-hidden="true"></i><span>Bugs</span></a></li>
                <li><a href="{{ route('showLogs') }}" target="_blank"><i class="fa fa-database" aria-hidden="true"></i><span>Logs</span></a></li>
            @endcan

            @if(Auth::check())
                <li class="header text-center">MENU</li>
                <li @if(Route::is("addAllocation") || Route::is('selectAllocation')) class="active" @endif><a href="{{ route('selectAllocation') }}"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i><span>Alocar Recurso</span></a></li>
                <li @if(Route::is("showAsset") || Route::is('detailsAsset')) class="active" @endif><a href="{{ route('showAsset') }}"><i class="fa fa-search" aria-hidden="true"></i><span>Consultar Recursos</span></a></li>
                <li {!! Route::is('software.index') ? "class='active'" : '' !!}><a href="{{ route('software.index') }}"><i class="fa fa-desktop"></i><span>Consultar softwares</span></a></li>
                <li @if(Route::is("addBug")) class="active" @endif><a href="{{ route('addBug') }}"><i class="fa fa-bug" aria-hidden="true"></i><span>Reportar Bug</span></a></li>
                <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Sair</span></a></li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
</aside>