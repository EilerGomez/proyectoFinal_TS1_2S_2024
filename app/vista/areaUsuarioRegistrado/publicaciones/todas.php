<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<div class="container">
    <h5>No olvides tu id: <?= $id ?></h5>
    <h1>Publicaciones</h1>

    <div id="posts">
        <?php foreach ($this->modeloEvento->traerEventosPublicados(0, $id) as $e): ?>
            <div class="post mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <!-- Mostrar el icono del tipo de público -->
                                <?php if ($e->tipo_publico === 'T'): ?>
                                    <i class="bi bi-globe" style="font-size: 1.5rem;" title="Todos"></i>
                                <?php elseif ($e->tipo_publico === 'ME'): ?>
                                    <i class="bi bi-person-fill" style="font-size: 1.5rem;" title="Menores de edad"></i>
                                <?php else: ?>
                                    <i class="bi bi-person" style="font-size: 1.5rem;" title="Mayores de edad"></i>
                                <?php endif; ?>
                                Publicado por <strong><?= $e->usuarioPublicador ?></strong><br>
                                <small class="text-muted">Fecha del evento: <?= $e->fecha ?> a las <?= $e->hora ?></small>
                            </div>

                            <div class="d-flex align-items-center">
                                <!-- Botón para "Deseo asistir" o "Ya no asistir" -->
                                <?php if ($e->asistiendo): ?>
                                    <a class="btn btn-warning mr-3" href="http://localhost/proyecto_final_ts1/?c=usuarioregistrado&a=PreguntarDesasistir&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>&idP=<?= $e->id ?>&idNot=<?= $e->usuarioNotificacion ?>&descripcionP=<?= $e->descripcion ?>">
                                        <i class="bi bi-x-circle" style="font-size: 1.5rem;" title="Ya no asistir"></i>
                                    </a>
                                <?php else: ?>
                                    <a class="btn btn-success mr-3" href="http://localhost/proyecto_final_ts1/?c=usuarioregistrado&a=PreguntarAsistir&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>&idP=<?= $e->id ?>&idNot=<?= $e->usuarioNotificacion ?>&descripcionP=<?= $e->descripcion ?>&cupoRestante=<?= $e->cupo_restante ?>">
                                        <i class="bi bi-check-circle" style="font-size: 1.5rem;" title="Deseo asistir"></i>
                                    </a>
                                <?php endif; ?>

                                <!-- Botón para "Reportar publicación" -->
                                <a class="btn btn-danger" href="http://localhost/proyecto_final_ts1/?c=usuarioregistrado&a=Reportar&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>&idP=<?= $e->id ?>">
                                    <i class="bi bi-flag" style="font-size: 1.5rem;" title="Reportar publicacion"></i>
                                </a>
                            </div>

                        </div>

                        <p class="mt-2">
                            Lugar: <strong><?= $e->lugar ?></strong> <br>
                            Público: <?= $e->tipo_publico === 'T' ? 'Todos' : ($e->tipo_publico === 'ME' ? 'Menores de edad' : 'Mayores de edad') ?>
                            <br>
                            <?= $e->descripcion ?>
                        </p>

                        <!-- Mostrar la imagen si está disponible -->
                        <?php if (!empty($e->imagen)): ?>
                            <img src="<?= $e->imagen ?>" class="img-fluid rounded mb-3" alt="Sin imagen">
                        <?php endif; ?><br>

                        <!-- Mostrar la URL de referencia del evento si existe -->
                        <?php if (!empty($e->url)): ?>
                            <a href="<?= $e->url ?>" target="_blank" class="btn btn-primary">Más información</a>
                        <?php endif; ?>

                        <!-- Información del cupo -->
                        <p class="mt-3">
                            Cupo restante: <strong><?= $e->cupo_restante ?></strong>
                        </p>

                        <!-- Mostrar el estado del evento -->
                        <p class="text-muted">
                            Estado del evento: <strong><?= $e->estado ?></strong><br>
                        </p>



                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>