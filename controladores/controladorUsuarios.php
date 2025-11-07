<?php
class ControladorUsuarios {
    private $conexion;
    
    public function __construct() {
        $this->conectarBD();
        $this->inicializarTabla();
    }
    
    private function conectarBD() {
        $servidor = "localhost";
        $usuario = "root";
        $password = "12345678";
        $basedatos = "taqueriabuena";
        
        $this->conexion = new mysqli($servidor, $usuario, $password, $basedatos);
        
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }
    
    private function inicializarTabla() {
        $this->conexion->query("CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario VARCHAR(50) NOT NULL UNIQUE,
            correo_telefono VARCHAR(100),
            contrasena VARCHAR(100) NOT NULL,
            fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        $checkData = $this->conexion->query("SELECT COUNT(*) as total FROM usuarios");
        $row = $checkData->fetch_assoc();
        if ($row['total'] == 0) {
            $this->insertarDatosEjemplo();
        }
    }
    
    private function insertarDatosEjemplo() {
        $usuariosEjemplo = [
            "('usuario_premium', 'usuario.premium@gmail.com', 'premium123')",
            "('juan_perez', 'juan.perez@hotmail.com', 'juan456')",
            "('maria_lopez', '5512345678', 'maria789')",
            "('carlos_garcia', 'carlos.garcia@yahoo.com', 'carlos2024')",
            "('ana_rodriguez', '5523456789', 'ana123')",
            "('luis_martinez', 'luis.martinez@gmail.com', 'luis456')",
            "('sofia_hernandez', '5534567890', 'sofia789')",
            "('miguel_torres', 'miguel.torres@outlook.com', 'miguel123')"
        ];
        
        foreach ($usuariosEjemplo as $usuario) {
            $this->conexion->query("INSERT INTO usuarios (usuario, correo_telefono, contrasena) VALUES $usuario");
        }
    }
    
    public function obtenerUsuarios() {
        $sql = "SELECT id, usuario, correo_telefono, contrasena, fecha_registro FROM usuarios ORDER BY fecha_registro DESC";
        $resultado = $this->conexion->query($sql);
        return $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    public function cerrarConexion() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}

// Ejecutar controlador
$controlador = new ControladorUsuarios();
$usuarios = $controlador->obtenerUsuarios();
$controlador->cerrarConexion();
?>