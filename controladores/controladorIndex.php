<?php
// CONEXIÓN DIRECTA
$servidor = "localhost";
$usuario = "root";
$password = "12345678";
$basedatos = "taqueriabuena_";

$conexion = new mysqli($servidor, $usuario, $password, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// FUNCIÓN PARA CONSULTAS SIMPLES
function getMetricaSimple($conexion, $sql) {
    $result = $conexion->query($sql);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return ['total' => 0];
}

// Obtener métricas principales (solo las necesarias)
$metricas = [
    'stock' => getMetricaSimple($conexion, "SELECT COUNT(*) as total FROM producto")['total'],
    'total_empleados' => getMetricaSimple($conexion, "SELECT COUNT(*) as total FROM empleados")['total'],
    'administradores' => getMetricaSimple($conexion, "SELECT COUNT(*) as total FROM empleados WHERE ocupacion = 'admin'")['total'],
    'total_clientes' => getMetricaSimple($conexion, "SELECT COUNT(*) as total FROM clientes")['total'],
    'pedidos_pendientes' => getMetricaSimple($conexion, "SELECT COUNT(*) as total FROM pedidos WHERE estado IN ('pendiente', 'en_proceso', 'en_camino')")['total'],
    'pedidos_hoy' => getMetricaSimple($conexion, "SELECT COUNT(*) as total FROM pedidos WHERE DATE(fecha_pedido) = CURDATE()")['total']
];

// PRODUCTOS MÁS VENDIDOS (solo nombre, cantidad total y precio total)
$sql_top_productos = "SELECT 
    p.nombreproducto,
    SUM(pd.cantidad) as cantidad_total,
    SUM(pd.cantidad * pd.precio) as precio_total
FROM pedidos_detalles pd 
JOIN producto p ON pd.idproducto = p.idproducto 
GROUP BY p.idproducto, p.nombreproducto
ORDER BY cantidad_total DESC 
LIMIT 10";

$result_top = $conexion->query($sql_top_productos);
$productos_top = $result_top ? $result_top->fetch_all(MYSQLI_ASSOC) : [];

// PEDIDOS RECIENTES
$sql_pedidos_recientes = "SELECT 
    p.idpedido,
    p.estado,
    p.fecha_pedido,
    p.total,
    c.nombre as cliente_nombre
FROM pedidos p 
JOIN clientes c ON p.idcliente = c.idcliente 
WHERE p.estado IN ('pendiente', 'en_proceso', 'en_camino')
ORDER BY p.fecha_pedido DESC 
LIMIT 5";

$result_pedidos = $conexion->query($sql_pedidos_recientes);
$pedidos_recientes = $result_pedidos ? $result_pedidos->fetch_all(MYSQLI_ASSOC) : [];

$conexion->close();
?>