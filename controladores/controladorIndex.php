<?php
// CONEXIÓN DIRECTA
$servidor = "localhost";
$usidor = "root";
$password = "12345678";
$basedatos = "taqueriabuena";

$conexion = new mysqli($servidor, $usidor, $password, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// FUNCIÓN SEGURA con prepared statements
function getMetricaSegura($conexion, $sql) {
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Obtener métricas principales
$metricas = [
    'stock' => getMetricaSegura($conexion, "SELECT COUNT(*) as total FROM producto")['total'],
    'ventas' => getMetricaSegura($conexion, "SELECT SUM(cantidad_vendida) as total FROM ventas")['total'] ?: 0,
    'productos_diferentes' => getMetricaSegura($conexion, "SELECT COUNT(DISTINCT nombreproducto) as total FROM producto")['total'],
    'ingresos' => getMetricaSegura($conexion, "SELECT SUM(v.cantidad_vendida * p.precio) as total FROM ventas v JOIN producto p ON v.idproducto = p.idproducto")['total'] ?: 0,
    'total_empleados' => getMetricaSegura($conexion, "SELECT COUNT(*) as total FROM empleados")['total'],
    'administradores' => getMetricaSegura($conexion, "SELECT COUNT(*) as total FROM empleados WHERE ocupacion = 'admin'")['total'],
    'total_clientes' => getMetricaSegura($conexion, "SELECT COUNT(*) as total FROM clientes")['total']
];

// PRODUCTOS MÁS VENDIDOS HOY
$sql_top_productos = "SELECT 
    p.nombreproducto,
    SUM(v.cantidad_vendida) as ventas_hoy,
    SUM(v.cantidad_vendida * p.precio) as ingresos
FROM ventas v 
JOIN producto p ON v.idproducto = p.idproducto 
WHERE DATE(v.fecha_venta) = CURDATE()
GROUP BY p.idproducto, p.nombreproducto 
ORDER BY ventas_hoy DESC 
LIMIT 10";

$result_top = $conexion->query($sql_top_productos);
$productos_top = $result_top ? $result_top->fetch_all(MYSQLI_ASSOC) : [];

// Totales del día
$total_vendido_hoy = 0;
$ingreso_total_hoy = 0;

foreach($productos_top as $producto) {
    $total_vendido_hoy += $producto['ventas_hoy'];
    $ingreso_total_hoy += $producto['ingresos'];
}
?>