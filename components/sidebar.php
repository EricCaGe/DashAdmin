<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: linear-gradient(135deg, #526A37 0%, #3a4c27 100%);">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="img/logo.png" alt="Logo" style="height: 75px; width: auto;">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo (!isset($_GET['page']) || $_GET['page'] == 'dashboard') ? 'active' : ''; ?>">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Gestión
    </div>

    <!-- Nav Item - Stock -->
    <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'stock') ? 'active' : ''; ?>">
        <a class="nav-link" href="index.php?page=stock">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Stock</span>
        </a>
    </li>

    <!-- Nav Item - Ventas -->
    <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'ventas') ? 'active' : ''; ?>">
        <a class="nav-link" href="index.php?page=ventas">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Ventas</span>
        </a>
    </li>

    <!-- Nav Item - Empleados -->
    <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'empleados') ? 'active' : ''; ?>">
        <a class="nav-link" href="index.php?page=empleados">
            <i class="fas fa-fw fa-users"></i>
            <span>Empleados</span>
        </a>
    </li>

    <!-- Nav Item - Clientes -->
    <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'clientes') ? 'active' : ''; ?>">
        <a class="nav-link" href="index.php?page=clientes">
            <i class="fas fa-fw fa-address-book"></i>
            <span>Clientes</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Cerrar Sesión -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Cerrar Sesión</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->