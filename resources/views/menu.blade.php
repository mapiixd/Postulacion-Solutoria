<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">

    <a href="/" class="brand-link">
        Postulación Solutoria
    </a>
    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("inicio") ? "active" : "" }}" href="{{ route("inicio") }}">
                        <i class="fas fa-home nav-icon">
                        </i>
                        <p>
                            Inicio
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="indicadores-crud">
                        <i class="fa-fw fas fa-list nav-icon">
                        </i>
                        <p>
                        CRUD Indicadores      
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="grafico">
                        <i class="fa-fw fas fa-calendar nav-icon">
                        </i>
                        <p>
                        Gráfico      
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="llenardb">
                        <i class="fa-fw fas fa-calendar nav-icon">
                        </i>
                        <p>
                        Llenar Base de Datos      
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>