<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @can('administrate')
                <li class="header text-center">ADMINISTRAÇÃO</li>
                <li @if(Route::is('regra.index') || Route::is('regra.edit')) class="active" @endif><a href="{{ route('regra.index') }}"><i class="fa fa-cogs" aria-hidden="true"></i><span>Visualizar Regras</span></a></li>
                <li @if(Route::is('selectDetailsAllocation') || Route::is('detailsAllocation')) class="active" @endif><a href="{{ route('detailsAllocation') }}"><i class="fa fa-search" aria-hidden="true"></i><span>Consultar Reserva</span></a></li>

                <li class="treeview {!! Route::is('tiporecurso.index') || Route::is('tiporecurso.create') || Route::is('tiporecurso.edit') || Route::is('recurso.create') ? "active" : '' !!}">
                    <a href="#">
                        <i class="fa fa-gear"></i><span>Recursos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li @if(Route::is("recurso.create")) class="active" @endif><a href="{{ route('recurso.create') }}"><i class="fa fa-plus-circle" aria-hidden="true"></i><span>Adicionar Recurso</span></a></li>


                        <li class="treeview {{ Route::is('tiporecurso.index') || Route::is('tiporecurso.create') ? 'active' : '' }}">
                            <a href="#">
                                <i class="fa fa-puzzle-piece"></i> Tipos<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li {!! Route::is('tiporecurso.index') ? "class='active'" : '' !!}><a href="{{ route('tiporecurso.index') }}"><i class="fa fa-th-list"></i> Listar</a></li>
                                <li {!! Route::is('tiporecurso.create') ? "class='active'" : '' !!}><a href="{{ route('tiporecurso.create') }}"><i class="fa fa-plus-circle"></i> Adicionar</a></li>
                            </ul>
                        </li>
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

                <li class="treeview {{ Route::is('usuario.create') || Route::is('usuario.index') || Route::is('usuario.edit') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-users"></i><span>Usuários</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li @if(Route::is("usuario.create")) class="active" @endif><a href="{{ route('usuario.create') }}"><i class="fa fa-user-plus" aria-hidden="true"></i><span>Cadastrar</span></a></li>
                        <li @if(Route::is("usuario.index")) class="active" @endif><a href="{{ route('usuario.index') }}"><i class="fa fa-th-list" aria-hidden="true"></i><span>Listar</span></a></li>
                    </ul>
                </li>

                <li @if(Route::is("bug.index") || Route::is('bug.show')) class="active" @endif><a href="{{ route('bug.index') }}"><i class="fa fa-bug" aria-hidden="true"></i><span>Bugs</span></a></li>
                <li><a href="{{ route('showLogs') }}" target="_blank"><i class="fa fa-database" aria-hidden="true"></i><span>Logs</span></a></li>
            @endcan

            @if(Auth::check())
                <li class="header text-center">MENU</li>
                <li @if(Route::is("addAllocation") || Route::is('selectAllocation')) class="active" @endif><a href="{{ route('selectAllocation') }}"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i><span>Alocar Recurso</span></a></li>
                <li @if(Route::is("recurso.index") || Route::is('recurso.edit')) class="active" @endif><a href="{{ route('recurso.index') }}"><i class="fa fa-search" aria-hidden="true"></i><span>Consultar Recursos</span></a></li>
                <li {!! Route::is('software.index') ? "class='active'" : '' !!}><a href="{{ route('software.index') }}"><i class="fa fa-desktop"></i><span>Consultar softwares</span></a></li>
                <li @if(Route::is("bug.create")) class="active" @endif><a href="{{ route('bug.create') }}"><i class="fa fa-bug" aria-hidden="true"></i><span>Reportar Bug</span></a></li>
                <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Sair</span></a></li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
</aside>