<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<div class="container">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Reportes de publicaciones</h2>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Publicacion</th>
                    <th>Usuario reportador</th>
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->modeloReportesEvento->getReportesEventos() as $e): ?>
                    <tr>
                        <td><?= $e->id_evento ?></td>
                        <td><?= $e->usuario_reportador ?></td>
                        <td><?= $e->motivo ?></td>
                        <td><?= $e->estado ?></td>
                        <td>
                            <!-- Botón de detalles -->
                            <a href="http://localhost/proyecto_final_ts1/?c=admin&a=DetallesEvento&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>&idP=<?= $e->id_evento ?>" class="btn btn-info btn-sm" title="Detalles">
                                <i class="bi bi-eye"></i>
                            </a>
                            <!-- Botón de aceptar reporte -->
                            <?php if ($e->estado === 'PENDIENTE'): ?>
                                <a href="http://localhost/proyecto_final_ts1/?c=admin&a=AceptarReporteEvento&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>&idP=<?= $e->id_evento ?>&idUR=<?= $e->id_usuario_reportador ?>" class="btn btn-success btn-sm" title="Aceptar reporte">
                                    <i class="bi bi-check-circle"></i>
                                </a>
                            <?php else: ?>
                                <button class="btn btn-success btn-sm" disabled title="Aceptar reporte">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>