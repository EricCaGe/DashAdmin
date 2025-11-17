<?php
// CONEXIÓN A BASE DE DATOS
$servidor = "localhost";
$usuario = "root";
$password = "12345678";
$basedatos = "taqueriabuena_";

$conexion = new mysqli($servidor, $usuario, $password, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// MANEJAR CAMBIOS DE ESTADO
if(isset($_GET['en_proceso'])) {
    $id = intval($_GET['en_proceso']);
    $stmt = $conexion->prepare("UPDATE pedidos SET estado = 'en_proceso' WHERE idpedido = ?");
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        header("Location: index.php?page=pedidos&mensaje=Pedido+marcado+como+en+proceso");
        exit();
    } else {
        header("Location: index.php?page=pedidos&error=Error+al+actualizar+el+pedido");
        exit();
    }
}

if(isset($_GET['en_camino'])) {
    $id = intval($_GET['en_camino']);
    $stmt = $conexion->prepare("UPDATE pedidos SET estado = 'en_camino' WHERE idpedido = ?");
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        header("Location: index.php?page=pedidos&mensaje=Pedido+marcado+como+en+camino");
        exit();
    } else {
        header("Location: index.php?page=pedidos&error=Error+al+actualizar+el+pedido");
        exit();
    }
}

if(isset($_GET['entregado'])) {
    $id = intval($_GET['entregado']);
    $stmt = $conexion->prepare("UPDATE pedidos SET estado = 'entregado' WHERE idpedido = ?");
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        header("Location: index.php?page=pedidos&mensaje=Pedido+marcado+como+entregado");
        exit();
    } else {
        header("Location: index.php?page=pedidos&error=Error+al+actualizar+el+pedido");
        exit();
    }
}

// OBTENER PEDIDOS CON TODA LA INFORMACIÓN
$sql = "SELECT 
            p.idpedido,
            p.estado,
            p.fecha_pedido,
            p.total,
            c.nombre as cliente_nombre,
            c.direccion as cliente_direccion,
            c.telefono as cliente_telefono,
            pd.cantidad,
            pd.precio as precio_unitario,
            pd.especificaciones,
            pr.nombreproducto,
            pr.precio as precio_producto
        FROM pedidos p
        JOIN clientes c ON p.idcliente = c.idcliente
        JOIN pedidos_detalles pd ON p.idpedido = pd.idpedido
        JOIN producto pr ON pd.idproducto = pr.idproducto
        WHERE p.estado IN ('pendiente', 'en_proceso', 'en_camino')
        ORDER BY 
            CASE 
                WHEN p.estado = 'en_proceso' THEN 1
                WHEN p.estado = 'en_camino' THEN 2
                WHEN p.estado = 'pendiente' THEN 3
                ELSE 4
            END, 
            p.fecha_pedido ASC";

$resultado = $conexion->query($sql);
$pedidos_completos = $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];

// ORGANIZAR LOS DATOS POR PEDIDO
$pedidos = [];
foreach($pedidos_completos as $fila) {
    $id_pedido = $fila['idpedido'];
    
    if(!isset($pedidos[$id_pedido])) {
        $pedidos[$id_pedido] = [
            'idpedido' => $fila['idpedido'],
            'estado' => $fila['estado'],
            'fecha_pedido' => $fila['fecha_pedido'],
            'total' => $fila['total'],
            'cliente_nombre' => $fila['cliente_nombre'],
            'cliente_direccion' => $fila['cliente_direccion'],
            'cliente_telefono' => $fila['cliente_telefono'],
            'detalles' => []
        ];
    }
    
    // Agregar cada producto del pedido
    $pedidos[$id_pedido]['detalles'][] = [
        'nombreproducto' => $fila['nombreproducto'],
        'cantidad' => $fila['cantidad'],
        'precio' => $fila['precio_unitario'],
        'especificaciones' => $fila['especificaciones']
    ];
}

// Convertir el array asociativo a indexado
$pedidos = array_values($pedidos);

$conexion->close();

// OBTENER MENSAJES
$mensaje = $_GET['mensaje'] ?? '';
$error = $_GET['error'] ?? '';

// INCLUIR LA VISTA - ESTO DEBE IR AL FINAL DEL ARCHIVO
include 'pages/pedidos.php';
?>