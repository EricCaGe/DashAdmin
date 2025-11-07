<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados - Gestión de Personal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/stylesEmpleados.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid py-3">
        <!-- MENSAJES DE ALERTA -->
        <?php if(!empty($mensaje)): ?>
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= htmlspecialchars(urldecode($mensaje)) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if(!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= htmlspecialchars(urldecode($error)) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- ENCABEZADO RESPONSIVE -->
        <div class="row mb-3">
            <div class="col-12">
                <h1 class="empleados-header">
                    <i class="fas fa-users me-2 d-none d-sm-inline"></i>Gestión de Empleados
                </h1>
            </div>
        </div>

        <!-- FALTA ESTE DIV ROW QUE ENVUELVE LAS COLUMNAS -->
        <div class="row g-3">
            <!-- COLUMNA IZQUIERDA - TABLA CON SCROLL DUAL (MÁS COMPACTA) -->
            <div class="col-12 col-xl-8 col-lg-7">
                <div class="tabla-container-dark compacto">
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
                        <h2 class="mb-0 h5">
                            <i class="fas fa-list me-2"></i>Lista de Empleados
                        </h2>
                        <div class="table-info d-none d-md-block">
                            <small class="text-muted">Mostrando <?= count($empleados) ?> empleados</small>
                        </div>
                    </div>
                    
                    <!-- CONTENEDOR CON SCROLL HORIZONTAL Y VERTICAL MÁS COMPACTO -->
                    <div class="table-scroll-container compacto">
                        <div class="table-responsive-custom">
                            <table class="table table-striped table-dark-custom compacto">
                                <thead class="table-header-dark compacto">
                                    <tr>
                                        <th class="text-center" width="60px">ID</th>
                                        <th width="150px">USUARIO</th>
                                        <th width="180px">CORREO/TELÉFONO</th>
                                        <th class="text-center" width="110px">OCUPACIÓN</th>
                                        <th class="text-center" width="90px">CONTRASEÑA</th>
                                        <th class="text-center" width="90px">ESTADO</th>
                                        <th class="text-center" width="130px">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($empleados)): ?>
                                        <?php foreach($empleados as $empleado): ?>
                                        <tr>
                                            <td class="text-center"><strong>#<?= $empleado['id'] ?></strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar me-2 compacto">
                                                        <?= strtoupper(substr($empleado['usuario'], 0, 1)) ?>
                                                    </div>
                                                    <div class="user-info">
                                                        <div class="user-name compacto"><?= htmlspecialchars($empleado['usuario']) ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="contact-info compacto">
                                                    <?= htmlspecialchars($empleado['correo_telefono']) ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge <?= $empleado['ocupacion'] == 'admin' ? 'admin-badge' : 'empleado-badge' ?> compacto">
                                                    <i class="fas <?= $empleado['ocupacion'] == 'admin' ? 'fa-crown' : 'fa-user' ?> me-1"></i>
                                                    <?= ucfirst($empleado['ocupacion']) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="password-dots compacto">••••••••</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success status-badge compacto">
                                                    <i class="fas fa-circle me-1"></i>
                                                    <span class="status-text">Activo</span>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group-custom compacto" role="group">
                                                    <button class="btn btn-warning btn-action compacto" onclick="editarEmpleado(<?= $empleado['id'] ?>, '<?= addslashes($empleado['usuario']) ?>', '<?= addslashes($empleado['correo_telefono']) ?>', '<?= $empleado['ocupacion'] ?>')">
                                                        <i class="fas fa-edit"></i>
                                                        <span class="btn-text">Editar</span>
                                                    </button>
                                                    <a href="index.php?page=empleados&eliminar=<?= $empleado['id'] ?>" class="btn btn-danger btn-action compacto" onclick="return confirm('¿Está seguro de eliminar a \'<?= addslashes($empleado['usuario']) ?>\'?')">
                                                        <i class="fas fa-trash"></i>
                                                        <span class="btn-text">Eliminar</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="empty-state compacto">
                                                    <i class="fas fa-users fa-2x text-muted mb-2"></i>
                                                    <h6 class="text-muted">No hay empleados registrados</h6>
                                                    <p class="text-muted mb-0 small">Agrega tu primer empleado usando el formulario</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA - FORMULARIO RESPONSIVE (MÁS COMPACTO) -->
            <div class="col-12 col-xl-4 col-lg-5">
                <div class="form-container-dark compacto">
                    <div class="form-card-dark compacto">
                        <h4 class="h5">
                            <i class="fas fa-user-plus me-2"></i>Gestión de Empleados
                        </h4>
                        <form method="POST" id="formEmpleado">
                            <input type="hidden" id="idEmpleado" name="idEmpleado">
                            
                            <div class="mb-2">
                                <label class="form-label small">
                                    <i class="fas fa-user me-1"></i>Usuario
                                </label>
                                <input type="text" id="usuario" name="usuario" class="form-control-dark compacto" placeholder="Nombre de usuario" required>
                            </div>
                            
                            <div class="mb-2">
                                <label class="form-label small">
                                    <i class="fas fa-envelope me-1"></i>Correo o Teléfono
                                </label>
                                <input type="text" id="correo_telefono" name="correo_telefono" class="form-control-dark compacto" placeholder="correo@ejemplo.com o 1234567890" required>
                            </div>
                            
                            <div class="mb-2">
                                <label class="form-label small">
                                    <i class="fas fa-briefcase me-1"></i>Ocupación
                                </label>
                                <select id="ocupacion" name="ocupacion" class="form-control-dark compacto" required>
                                    <option value="empleado">👨‍💼 Empleado</option>
                                    <option value="admin">👑 Administrador</option>
                                </select>
                            </div>
                            
                            <div class="mb-2">
                                <label class="form-label small">
                                    <i class="fas fa-lock me-1"></i>Contraseña
                                </label>
                                <input type="password" id="contrasena" name="contrasena" class="form-control-dark compacto" placeholder="Dejar vacío para no cambiar">
                                <small class="form-text small">Mínimo 6 caracteres</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label small">
                                    <i class="fas fa-lock me-1"></i>Confirmar Contraseña
                                </label>
                                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" class="form-control-dark compacto" placeholder="Confirmar contraseña">
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-sm btn-submit">
                                    <i class="fas fa-save me-1"></i>
                                    <span class="btn-submit-text">Guardar Empleado</span>
                                </button>
                                <button type="button" onclick="limpiarFormulario()" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-plus me-1"></i>
                                    <span class="btn-text">Nuevo Empleado</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN DEL DIV ROW -->
    </div>

    <script>
    function editarEmpleado(id, usuario, correo_telefono, ocupacion) {
        document.getElementById('idEmpleado').value = id;
        document.getElementById('usuario').value = usuario;
        document.getElementById('correo_telefono').value = correo_telefono;
        document.getElementById('ocupacion').value = ocupacion;
        document.getElementById('contrasena').value = '';
        document.getElementById('confirmar_contrasena').value = '';
        
        // Cambiar texto del botón
        document.querySelector('.btn-submit-text').textContent = 'Actualizar Empleado';
        
        // Scroll suave al formulario en móviles
        if (window.innerWidth < 1200) {
            document.querySelector('.form-container-dark').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    function limpiarFormulario() {
        document.getElementById('formEmpleado').reset();
        document.getElementById('idEmpleado').value = '';
        document.getElementById('ocupacion').value = 'empleado';
        document.querySelector('.btn-submit-text').textContent = 'Guardar Empleado';
        document.getElementById('usuario').focus();
    }

    // Validación de contraseñas
    document.getElementById('formEmpleado').addEventListener('submit', function(e) {
        const contrasena = document.getElementById('contrasena').value;
        const confirmar = document.getElementById('confirmar_contrasena').value;
        
        if (contrasena !== '' && contrasena !== confirmar) {
            e.preventDefault();
            alert('Las contraseñas no coinciden');
            document.getElementById('confirmar_contrasena').focus();
        }
    });

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