<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<div class="container">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Publicaciones</h2>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Publicacion</th>
                    <th>Lugar</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Publico</th>
                    <th>Aprobacion</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->modeloEvento1->getEventosParaAdmin() as $e): ?>
                    <tr>
                        <td><?= $e->id ?></td>
                        <td><?= $e->lugar ?></td>
                        <td><?= $e->fecha ?></td>
                        <td><?= $e->hora ?></td>
                        <td>
                            <?php
                            // Determinar el tipo de público según el valor
                            switch ($e->tipo_publico) {
                                case 'T':
                                    echo 'Todos';
                                    break;
                                case 'MA':
                                    echo 'Mayores de edad';
                                    break;
                                case 'ME':
                                    echo 'Menores de edad';
                                    break;
                                default:
                                    echo 'Desconocido';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            // Mostrar el estado de aprobación
                            echo $e->aprobacion ? 'Sí aprobada' : 'No aprobada';
                            ?>
                        </td>
                        <td>
                            <!-- Botón de detalles -->
                            <a href="http://localhost/proyecto_final_ts1/?c=admin&a=DetallesEvento&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>&idP=<?= $e->id ?>" class="btn btn-info btn-sm" title="Detalles">
                                <i class="bi bi-eye"></i>
                            </a>
                            <!-- Botón de aprobar o desaprobar la publicación -->
                            <?php if ($e->aprobacion == 0): ?>
                                <!-- Mostrar botón de aprobar si no está aprobada -->
                                <a href="http://localhost/proyecto_final_ts1/?c=admin&a=AprobarPublicacion&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>&idP=<?= $e->id ?>" class="btn btn-success btn-sm" title="Aprobar publicación">
                                    <i class="bi bi-check-circle"></i>
                                </a>
                            <?php else: ?>
                                <!-- Mostrar botón de desaprobar si ya está aprobada -->
                                <a href="http://localhost/proyecto_final_ts1/?c=admin&a=AprobarPublicacion&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>&idP=<?= $e->id ?>" class="btn btn-warning btn-sm" title="Desaprobar publicación">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>