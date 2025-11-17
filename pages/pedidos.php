<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Sistema de Taquería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/stylesPedidos.css" rel="stylesheet">
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

        <div class="pedidos-container">
            <h2><i class="fas fa-motorcycle me-2"></i>Órdenes a Domicilio</h2>
            
            <?php if(!empty($pedidos)): ?>
                <?php foreach($pedidos as $index => $pedido): ?>
                <div class="pedido-card estado-<?= $pedido['estado'] ?>">
                    <!-- HEADER DEL PEDIDO -->
                    <div class="pedido-header">
                        <div class="pedido-info">
                            <h4>Orden #<?= $pedido['idpedido'] ?></h4>
                            <p><strong>Nombre:</strong> <?= htmlspecialchars($pedido['cliente_nombre']) ?></p>
                            <p><strong>Dirección:</strong> <?= htmlspecialchars($pedido['cliente_direccion']) ?></p>
                            <p class="telefono"><strong>Teléfono:</strong> <?= htmlspecialchars($pedido['cliente_telefono']) ?></p>
                            <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?></p>
                        </div>
                        <div class="estado-pedido">
                            <?php
                            $estado_texto = '';
                            $badge_class = '';
                            switch($pedido['estado']) {
                                case 'pendiente':
                                    $estado_texto = 'Pendiente';
                                    $badge_class = 'badge-pendiente';
                                    break;
                                case 'en_proceso':
                                    $estado_texto = 'En Proceso';
                                    $badge_class = 'badge-proceso';
                                    break;
                                case 'en_camino':
                                    $estado_texto = 'En Camino';
                                    $badge_class = 'badge-camino';
                                    break;
                                case 'entregado':
                                    $estado_texto = 'Entregado';
                                    $badge_class = 'badge-entregado';
                                    break;
                            }
                            ?>
                            <span class="badge-estado <?= $badge_class ?>">
                                <?= $estado_texto ?>
                            </span>
                        </div>
                    </div>

                    <!-- TABLA DE PRODUCTOS -->
                    <div class="tabla-productos">
                        <table>
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Especificaciones</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total_pedido = 0;
                                foreach($pedido['detalles'] as $detalle): 
                                    $subtotal = $detalle['cantidad'] * $detalle['precio'];
                                    $total_pedido += $subtotal;
                                ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($detalle['nombreproducto']) ?></strong></td>
                                    <td><?= !empty($detalle['especificaciones']) ? htmlspecialchars($detalle['especificaciones']) : '<em class="text-muted">Sin especificaciones</em>' ?></td>
                                    <td class="text-center"><?= $detalle['cantidad'] ?></td>
                                    <td class="text-end">$<?= number_format($subtotal, 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- FOOTER CON TOTAL Y ACCIONES -->
                    <div class="pedido-footer">
                        <div class="total-pedido">
                            Total: $<?= number_format($total_pedido, 2) ?>
                        </div>
                        <div class="acciones-pedido">
                            <?php if($pedido['estado'] == 'pendiente'): ?>
                                <a href="index.php?page=pedidos&en_proceso=<?= $pedido['idpedido'] ?>" class="btn btn-proceso">
                                    <i class="fas fa-play me-1"></i>Iniciar Preparación
                                </a>
                            <?php elseif($pedido['estado'] == 'en_proceso'): ?>
                                <a href="index.php?page=pedidos&en_camino=<?= $pedido['idpedido'] ?>" class="btn btn-camino">
                                    <i class="fas fa-motorcycle me-1"></i>Marcar como En Camino
                                </a>
                            <?php elseif($pedido['estado'] == 'en_camino'): ?>
                                <a href="index.php?page=pedidos&entregado=<?= $pedido['idpedido'] ?>" class="btn btn-entregado">
                                    <i class="fas fa-check-circle me-1"></i>Marcar como Entregado
                                </a>
                            <?php else: ?>
                                <button class="btn btn-completado" disabled>
                                    <i class="fas fa-check me-1"></i>Pedido Completado
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="estado-vacio">
                    <i class="fas fa-clipboard-list"></i>
                    <h4>No hay pedidos activos</h4>
                    <p>Los nuevos pedidos aparecerán aquí automáticamente</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    // Auto-recargar la página cada 30 segundos para ver nuevos pedidos
    setTimeout(function() {
        window.location.reload();
    }, 30000);

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