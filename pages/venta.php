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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for index -->
    <link href="./styles/stylesIndex.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body id="page-top" class="bg-image" style="background-image: url('./img/TacosFondo.png');">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Incluir Sidebar -->
        <?php include 'components/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="content-overlay d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <?php
                // Determinar qué página cargar
                $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                
                // Si es dashboard, cargar contenido normal
                if ($page == 'dashboard') {
                ?>
                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow glass-effect">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Usuario</span>
                                    <img class="img-profile rounded-circle" src="./img/user-profile.jpg" width="40" height="40">
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Contenido del Dashboard -->
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4 glass-effect p-3 rounded">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard Principal</h1>
                            <a href="#" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Generar Reporte
                            </a>
                        </div>

                        <div class="row">
                            <!-- Card Stock -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2 glass-effect">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Productos en Stock</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php
                                                    // Contar productos en stock
                                                    include './conexion/conexion.php';
                                                    $sql = "SELECT COUNT(*) as total FROM producto";
                                                    $result = $conexion->query($sql);
                                                    $row = $result->fetch_assoc();
                                                    echo $row['total'];
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-boxes fa-2x text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Ventas -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2 glass-effect">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Ventas Totales</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php
                                                    // Sumar ventas totales
                                                    $sql = "SELECT SUM(cantidad_vendida) as total FROM ventas";
                                                    $result = $conexion->query($sql);
                                                    $row = $result->fetch_assoc();
                                                    echo $row['total'] ?: '0';
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Productos -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2 glass-effect">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Productos Diferentes</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php
                                                    // Contar productos únicos
                                                    $sql = "SELECT COUNT(DISTINCT nombreproducto) as total FROM producto";
                                                    $result = $conexion->query($sql);
                                                    $row = $result->fetch_assoc();
                                                    echo $row['total'];
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-2x text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Ingresos -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2 glass-effect">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Ingresos Totales</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    $<?php
                                                    // Calcular ingresos totales
                                                    $sql = "SELECT SUM(v.cantidad_vendida * p.precio) as total 
                                                            FROM ventas v 
                                                            JOIN producto p ON v.idproducto = p.idproducto";
                                                    $result = $conexion->query($sql);
                                                    $row = $result->fetch_assoc();
                                                    echo number_format($row['total'] ?: 0, 2);
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-chart-line fa-2x text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfica de Ventas en Dashboard -->
                        <div class="row">
                            <div class="col-xl-8 col-lg-7">
                                <div class="card shadow mb-4 glass-effect">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Ventas por Producto</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-pie pt-4 pb-2">
                                            <canvas id="myPieChart" width="400" height="200"></canvas>
                                        </div>
                                        <div class="mt-4 text-center small" id="chartLegend"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                    // Si es otra página (stock, ventas, etc.), incluir el archivo completo
                    $pageFile = 'pages/' . $page . '.php';
                    if (file_exists($pageFile)) {
                        include $pageFile;
                    } else {
                        echo '<div class="container-fluid">';
                        echo '<div class="alert alert-danger">Página no encontrada: ' . $page . '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Gráfica del Dashboard -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Datos para la gráfica
        fetch('./pages/get_ventas_data.php')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('myPieChart').getContext('2d');
                const myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: data.productos,
                        datasets: [{
                            data: data.ventas,
                            backgroundColor: ['#526A37', '#EC9706', '#dc3545', '#6b1a00', '#0d6efd', '#17a2b8'],
                            hoverBackgroundColor: ['#3a4c27', '#d08605', '#c82333', '#4a1300', '#0056b3', '#138496'],
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                        },
                        legend: {
                            display: false
                        },
                        cutoutPercentage: 80,
                    },
                });

                // Crear leyenda
                let legendHtml = '';
                data.productos.forEach((producto, index) => {
                    legendHtml += `<span class="mr-3"><i class="fas fa-circle" style="color: ${myPieChart.data.datasets[0].backgroundColor[index]}"></i> ${producto}</span>`;
                });
                document.getElementById('chartLegend').innerHTML = legendHtml;
            })
            .catch(error => {
                console.error('Error loading chart data:', error);
                document.getElementById('chartLegend').innerHTML = 'Error cargando datos de ventas';
            });
    });
    </script>

</body>
</html>