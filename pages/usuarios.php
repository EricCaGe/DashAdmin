
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Base de Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="stylesUsuarios.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="usuarios-header">
                    <i class="fas fa-users me-2"></i>Base de Datos de Usuarios
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="tabla-container">
                    <div class="table-scroll-container">
                        <table class="table table-striped table-usuarios">
                            <thead class="table-header">
                                <tr>
                                    <th width="80px">ID</th>
                                    <th width="200px">USUARIO</th>
                                    <th width="250px">CORREO/TELÉFONO</th>
                                    <th width="150px">CONTRASEÑA</th>
                                    <th width="150px">FECHA REGISTRO</th>
                                    <th width="120px">ESTADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($usuarios)): ?>
                                    <?php foreach($usuarios as $usuario): ?>
                                    <tr>
                                        <td class="text-center"><strong>#<?= $usuario['id'] ?></strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-2">
                                                    <?= strtoupper(substr($usuario['usuario'], 0, 1)) ?>
                                                </div>
                                                <div class="user-info">
                                                    <div class="user-name"><?= htmlspecialchars($usuario['usuario']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="contact-info">
                                                <?= htmlspecialchars($usuario['correo_telefono']) ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="password-dots">••••••••</span>
                                        </td>
                                        <td class="text-center">
                                            <?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success">
                                                <i class="fas fa-circle me-1"></i>
                                                Activo
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No hay usuarios registrados</h5>
                                                <p class="text-muted mb-0">No se encontraron usuarios en la base de datos</p>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>