<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock - Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/stylesStock.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
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
            <!-- COLUMNA IZQUIERDA - TABLA DE PRODUCTOS CON SCROLL DUAL MEJORADO -->
<div class="col-12 col-lg-8">
    <div class="tabla-container">
        <h2 class="mb-4"><i class="fas fa-boxes me-2"></i>Inventario de Productos</h2>
        
        <!-- CONTENEDOR CON SCROLL DUAL MEJORADO -->
        <div class="table-scroll-container" id="tableScroll">
            <div class="table-responsive-custom">
                <table class="table table-striped table-amarilla">
                    <thead class="table-header">
                        <tr>
                            <th>#</th>
                            <th>PRODUCTO</th>
                            <th class="text-center">CANTIDAD</th>
                            <th class="text-end">PRECIO</th>
                            <th class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($productos)): ?>
                            <?php foreach($productos as $index => $producto): ?>
                            <tr>
                                <td><strong><?= $index + 1 ?></strong></td>
                                <td><?= htmlspecialchars($producto['nombreproducto']) ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $producto['cantidad'] > 10 ? 'bg-success' : ($producto['cantidad'] > 0 ? 'bg-warning' : 'bg-danger') ?>">
                                        <?= $producto['cantidad'] ?> unidades
                                    </span>
                                </td>
                                <td class="text-end"><strong>$<?= number_format($producto['precio'], 2) ?></strong></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-warning" onclick="editarProducto(<?= $producto['idproducto'] ?>, '<?= addslashes($producto['nombreproducto']) ?>', <?= $producto['cantidad'] ?>, <?= $producto['precio'] ?>)">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </button>
                                        <a href="index.php?page=stock&eliminar=<?= $producto['idproducto'] ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar \'<?= addslashes($producto['nombreproducto']) ?>\'?')">
                                            <i class="fas fa-trash me-1"></i>Eliminar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-boxes fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No hay productos registrados</h5>
                                    <p class="text-muted mb-0">Agrega tu primer producto usando el formulario</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                    
                    

            <!-- COLUMNA DERECHA - FORMULARIO (IGUAL) -->
            <div class="col-12 col-lg-4">
                <div class="form-container">
                    <div class="form-card">
                        <h4><i class="fas fa-cube me-2"></i>Gestión de Productos</h4>
                        <form method="POST" id="formProducto">
                            <input type="hidden" id="idProducto" name="idProducto">
                            
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-tag me-1"></i>Nombre del Producto</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ej: Taco Pastor" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-boxes me-1"></i>Cantidad en Stock</label>
                                <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="0" min="0" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label"><i class="fas fa-dollar-sign me-1"></i>Precio Unitario</label>
                                <input type="number" id="precio" name="precio" class="form-control" placeholder="0.00" step="0.01" min="0.01" required>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-1"></i>Guardar Producto
                                </button>
                                <button type="button" onclick="limpiarFormulario()" class="btn btn-secondary">
                                    <i class="fas fa-plus me-1"></i>Nuevo Producto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function editarProducto(id, nombre, cantidad, precio) {
        document.getElementById('idProducto').value = id;
        document.getElementById('nombre').value = nombre;
        document.getElementById('cantidad').value = cantidad;
        document.getElementById('precio').value = precio;
        
        // Cambiar texto del botón
        document.querySelector('button[type="submit"]').innerHTML = '<i class="fas fa-save me-1"></i>Actualizar Producto';
        
        // Scroll suave al formulario en móviles
        if (window.innerWidth < 992) {
            document.querySelector('.form-container').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    function limpiarFormulario() {
        document.getElementById('formProducto').reset();
        document.getElementById('idProducto').value = '';
        document.querySelector('button[type="submit"]').innerHTML = '<i class="fas fa-save me-1"></i>Guardar Producto';
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
    <script src="js/stock.js"></script>
</body>
</html>