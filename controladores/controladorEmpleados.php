<?php
// CONEXIÓN A BASE DE DATOS
$servidor = "localhost";
$usuario = "root";
$password = "12345678";
$basedatos = "taqueriabuena";

$conexion = new mysqli($servidor, $usuario, $password, $basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// MANEJAR ELIMINACIÓN DE EMPLEADO
if(isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conexion->prepare("DELETE FROM empleados WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        header("Location: index.php?page=empleados&mensaje=Empleado+eliminado+correctamente");
        exit();
    } else {
        header("Location: index.php?page=empleados&error=Error+al+eliminar+el+empleado");
        exit();
    }
}

// MANEJAR GUARDAR/ACTUALIZAR EMPLEADO
if($_POST && isset($_POST['usuario'])) {
    $id = $_POST['idEmpleado'] ?? '';
    $usuario = trim($_POST['usuario'] ?? '');
    $correo_telefono = trim($_POST['correo_telefono'] ?? '');
    $ocupacion = $_POST['ocupacion'] ?? 'empleado';
    $contrasena = $_POST['contrasena'] ?? '';
    
    // VALIDACIONES
    if(empty($usuario) || empty($correo_telefono)) {
        header("Location: index.php?page=empleados&error=Datos+inválidos");
        exit();
    }
    
    // VALIDAR CONTRASEÑAS SI SE ESTÁN CAMBIANDO
    if(!empty($contrasena)) {
        $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';
        if($contrasena !== $confirmar_contrasena) {
            header("Location: index.php?page=empleados&error=Las+contraseñas+no+coinciden");
            exit();
        }
    }
    
    if(empty($id)) {
        // INSERTAR NUEVO EMPLEADO
        if(!empty($contrasena)) {
            $stmt = $conexion->prepare("INSERT INTO empleados (usuario, correo_telefono, ocupacion, contrasena) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $usuario, $correo_telefono, $ocupacion, $contrasena);
        } else {
            $stmt = $conexion->prepare("INSERT INTO empleados (usuario, correo_telefono, ocupacion) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $usuario, $correo_telefono, $ocupacion);
        }
    } else {
        // ACTUALIZAR EMPLEADO EXISTENTE
        if(!empty($contrasena)) {
            $stmt = $conexion->prepare("UPDATE empleados SET usuario=?, correo_telefono=?, ocupacion=?, contrasena=? WHERE id=?");
            $stmt->bind_param("ssssi", $usuario, $correo_telefono, $ocupacion, $contrasena, $id);
        } else {
            $stmt = $conexion->prepare("UPDATE empleados SET usuario=?, correo_telefono=?, ocupacion=? WHERE id=?");
            $stmt->bind_param("sssi", $usuario, $correo_telefono, $ocupacion, $id);
        }
    }
    
    if($stmt->execute()) {
        header("Location: index.php?page=empleados&mensaje=Empleado+guardado+correctamente");
        exit();
    } else {
        header("Location: index.php?page=empleados&error=Error+al+guardar+el+empleado");
        exit();
    }
    $stmt->close();
}

// OBTENER TODOS LOS EMPLEADOS
$sql = "SELECT id, usuario, correo_telefono, ocupacion FROM empleados ORDER BY id";
$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    $empleados = $resultado->fetch_all(MYSQLI_ASSOC);
} else {
    $empleados = [];
}

// CALCULAR ESTADÍSTICAS
$total_empleados = count($empleados);
$total_admins = 0;
$total_empleados_role = 0;

foreach ($empleados as $empleado) {
    if ($empleado['ocupacion'] == 'admin') {
        $total_admins++;
    } else {
        $total_empleados_role++;
    }
}

$conexion->close();

// OBTENER MENSAJES
$mensaje = $_GET['mensaje'] ?? '';
$error = $_GET['error'] ?? '';

// INCLUIR LA VISTA
include 'pages/empleados.php';
?>