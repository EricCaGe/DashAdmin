<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Gestión del Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/stylesUsuarios.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid py-3">
        <!-- MENSAJES DE ALERTA -->
        <?php if(!empty($mensaje)): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= htmlspecialchars(urldecode($mensaje)) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if(!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= htmlspecialchars(urldecode($error)) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row g-3">
            <!-- COLUMNA IZQUIERDA - TABLA DE CLIENTES -->
            <div class="col-12 col-lg-8">
                <div class="tabla-container">
                    <h2 class="mb-4"><i class="fas fa-users me-2"></i>Gestión de Clientes</h2>
                    
                    <div class="table-scroll-container" id="tableScroll">
                        <div class="table-responsive-custom">
                            <table class="table table-striped table-amarilla">
                                <thead class="table-header">
                                    <tr>
                                        <th>#</th>
                                        <th>NOMBRE</th>
                                        <th>DIRECCIÓN</th>
                                        <th>TELÉFONO</th>
                                        <th class="text-center">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($clientes)): ?>
                                        <?php foreach($clientes as $index => $cliente): ?>
                                        <tr>
                                            <td><strong><?= $index + 1 ?></strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar">
                                                        <?= strtoupper(substr($cliente['nombre'], 0, 2)) ?>
                                                    </div>
                                                    <div class="ms-2">
                                                        <div class="user-name"><?= htmlspecialchars($cliente['nombre']) ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="contact-info">
                                                    <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                                    <?= htmlspecialchars($cliente['direccion']) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="contact-info">
                                                    <i class="fas fa-phone me-1 text-success"></i>
                                                    <?= htmlspecialchars($cliente['telefono']) ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button class="btn btn-warning" onclick="editarCliente(
                                                        <?= $cliente['idcliente'] ?>,
                                                        '<?= addslashes($cliente['nombre']) ?>',
                                                        '<?= addslashes($cliente['direccion']) ?>',
                                                        '<?= addslashes($cliente['telefono']) ?>'
                                                    )">
                                                        <i class="fas fa-edit me-1"></i>Editar
                                                    </button>
                                                    <a href="index.php?page=clientes&eliminar=<?= $cliente['idcliente'] ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar al cliente \'<?= addslashes($cliente['nombre']) ?>\'?')">
                                                        <i class="fas fa-trash me-1"></i>Eliminar
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No hay clientes registrados</h5>
                                                <p class="text-muted mb-0">Agrega tu primer cliente usando el formulario</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA - FORMULARIO -->
            <div class="col-12 col-lg-4">
                <div class="form-container">
                    <div class="form-card">
                        <h4><i class="fas fa-user-plus me-2"></i>Gestión de Clientes</h4>
                        <form method="POST" id="formCliente">
                            <input type="hidden" id="idCliente" name="idCliente">
                            
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-user me-1"></i>Nombre del Cliente</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ej: Juan Pérez" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Dirección</label>
                                <textarea id="direccion" name="direccion" class="form-control" rows="3" placeholder="Dirección completa del cliente" required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-phone me-1"></i>Teléfono</label>
                                <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="Ej: 555-123-4567" required>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-1"></i>Guardar Cliente
                                </button>
                                <button type="button" onclick="limpiarFormulario()" class="btn btn-secondary">
                                    <i class="fas fa-plus me-1"></i>Nuevo Cliente
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function editarCliente(id, nombre, direccion, telefono) {
        document.getElementById('idCliente').value = id;
        document.getElementById('nombre').value = nombre;
        document.getElementById('direccion').value = direccion;
        document.getElementById('telefono').value = telefono;
        
        // Cambiar texto del botón
        document.querySelector('button[type="submit"]').innerHTML = '<i class="fas fa-save me-1"></i>Actualizar Cliente';
        
        // Scroll suave al formulario en móviles
        if (window.innerWidth < 992) {
            document.querySelector('.form-container').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    function limpiarFormulario() {
        document.getElementById('formCliente').reset();
        document.getElementById('idCliente').value = '';
        document.querySelector('button[type="submit"]').innerHTML = '<i class="fas fa-save me-1"></i>Guardar Cliente';
        document.getElementById('nombre').focus();
    }

    // Auto-limpiar mensajes después de 5 segundos
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>