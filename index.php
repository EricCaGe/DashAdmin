<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistema - Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for index -->
    <link href="styles/stylesIndex.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top" class="bg-image" style="background-image: url('./images/TacosFondo.png');">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Incluir Sidebar -->
        <?php include 'components/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="content-overlay d-flex flex-column ">

            <!-- Main Content -->
            <div id="content">
                <?php
                // Determinar qué página cargar
                $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                
                // Si es dashboard, cargar contenido normal
                if ($page == 'dashboard') {
                    // INCLUIR CONTROLADOR - LÓGICA SEPARADA
                    include 'controladores/controladorIndex.php';
                ?>
                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow glass-effect">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Usuario</span>
                                    <img class="img-profile rounded-circle" src="images/user-profile.jpg">
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Contenido del Dashboard -->
                    <div class="container-fluid">
                        <!-- QUITAMOS EL HEADER DEL DASHBOARD -->
                        
                        <div class="row">
                            <!-- COLUMNA IZQUIERDA - PRODUCTOS MÁS VENDIDOS -->
                            <div class="col-xl-8 col-lg-7 mb-4">
                                <div class="card shadow glass-effect h-100">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: rgba(82, 106, 55, 0.9);">
                                        <h6 class="m-0 font-weight-bold text-white">
                                            <i class="fas fa-fire me-2"></i>Productos Más Vendidos
                                        </h6>
                                        <span class="badge bg-warning">Total General</span>
                                    </div>
                                    <div class="card-body p-0">
                                        <?php if(!empty($productos_top)): ?>
                                            <div class="table-responsive" style="max-height: 400px;">
                                                <table class="table table-hover mb-0">
                                                    <thead style="background: rgba(82, 106, 55, 0.1);">
                                                        <tr>
                                                            <th class="border-0">#</th>
                                                            <th class="border-0">Producto</th>
                                                            <th class="border-0">Cantidad Total</th>
                                                            <th class="border-0">Precio Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($productos_top as $index => $producto): ?>
                                                        <tr class="<?= $index % 2 === 0 ? 'bg-light' : '' ?>">
                                                            <td>
                                                                <?php if($index < 3): ?>
                                                                    <span class="badge bg-danger"><?= $index + 1 ?></span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-secondary"><?= $index + 1 ?></span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <strong><?= htmlspecialchars($producto['nombreproducto']) ?></strong>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-info text-dark"><?= $producto['cantidad_total'] ?> uds</span>
                                                            </td>
                                                            <td>
                                                                <span class="text-success fw-bold">$<?= number_format($producto['precio_total'], 2) ?></span>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-center py-5">
                                                <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                                                <h6 class="text-muted">No hay productos vendidos</h6>
                                                <small class="text-muted">Los productos vendidos aparecerán aquí</small>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Resumen compacto -->
                                        <div class="p-3" style="background: rgba(82, 106, 55, 0.05); border-top: 1px solid rgba(0,0,0,0.1);">
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Total Vendido</small>
                                                    <div class="fw-bold text-primary"><?= array_sum(array_column($productos_top, 'cantidad_total')) ?> uds</div>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Productos</small>
                                                    <div class="fw-bold text-success"><?= count($productos_top) ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- COLUMNA DERECHA - 6 CARDS DE MÉTRICAS -->
                            <div class="col-xl-4 col-lg-5">
                                <div class="row">
                                    <!-- Card Stock -->
                                    <div class="col-md-6 col-xl-12 mb-4">
                                        <div class="card border-left-primary shadow h-100 py-2 glass-effect">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                            Productos en Stock</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                            <?= $metricas['stock'] ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-boxes fa-2x text-primary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Pedidos Pendientes -->
                                    <div class="col-md-6 col-xl-12 mb-4">
                                        <div class="card border-left-warning shadow h-100 py-2 glass-effect">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                            Pedidos Activos</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                            <?= $metricas['pedidos_pendientes'] ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-clock fa-2x text-warning"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Pedidos Hoy -->
                                    <div class="col-md-6 col-xl-12 mb-4">
                                        <div class="card border-left-info shadow h-100 py-2 glass-effect">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                            Pedidos Hoy</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                            <?= $metricas['pedidos_hoy'] ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-shopping-bag fa-2x text-info"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Empleados -->
                                    <div class="col-md-6 col-xl-12 mb-4">
                                        <div class="card border-left-primary shadow h-100 py-2 glass-effect">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                            Total Empleados</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                            <?= $metricas['total_empleados'] ?>
                                                        </div>
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mt-1">
                                                            Administradores: <?= $metricas['administradores'] ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-users fa-2x text-primary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Clientes -->
                                    <div class="col-md-6 col-xl-12 mb-4">
                                        <div class="card border-left-success shadow h-100 py-2 glass-effect">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Total Clientes</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                            <?= $metricas['total_clientes'] ?>
                                                        </div>
                                                        <div class="text-xs text-gray-600 mt-1">
                                                            Año: <?= date('Y') ?> | Mes: <?= date('m') ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-user-friends fa-2x text-success"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Total Productos Vendidos -->
                                    <div class="col-md-6 col-xl-12 mb-4">
                                        <div class="card border-left-danger shadow h-100 py-2 glass-effect">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                            Total Vendido</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                            <?= array_sum(array_column($productos_top, 'cantidad_total')) ?> uds
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-chart-line fa-2x text-danger"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                    // Si es otra página (stock, venta, etc.), incluir el archivo completo
                  switch($page) {
    case 'stock':
        include 'controladores/controladorStock.php';
        break;
    case 'venta':
        include 'pages/venta.php';
        break;
    case 'empleados':
        include 'controladores/controladorEmpleados.php';
        break;
    case 'clientes':
    include 'controladores/controladorUsuarios.php';
    break;
    case 'pedidos':
    include 'controladores/controladorPedidos.php';
    break;
}
                }
                ?>
            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #526A37 0%, #3a4c27 100%); color: white;">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Cerrar Sesión" si estás listo para finalizar tu sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="login.html">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

</body>
</html>