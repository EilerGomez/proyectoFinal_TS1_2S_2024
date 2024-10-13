<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<div class="container">
    <h5>No olvides tu id: <?= $id ?></h5>
    <h1>Publicaciones de <?= htmlspecialchars($n) ?></h1>
    <div id="posts">
        <!-- Publicación 1 -->

        <?php foreach ($this->modeloEvento->traerEventos((int)$id) as $e): ?>
            <div class="post mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Publicado por ti</strong> <br>
                                <small class="text-muted">Fecha del evento: <?= $e->fecha ?> a las <?= $e->hora ?></small>
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
                            Cupo limitado: <strong><?= $e->cupo_limitado ?></strong> <br>
                            Cupo restante: <strong><?= $e->cupo_restante ?></strong>
                        </p>

                        <!-- Mostrar si está publicada o no según 'aprobacion' -->
                        <p class="text-muted">
                            Estado del evento: <strong><?= $e->estado ?></strong> <br>
                            <?php if ($e->aprobacion): ?>
                                <span class="text-success">Publicada</span>
                            <?php else: ?>
                                <span class="text-danger">No publicada</span>
                            <?php endif; ?>
                        </p>

                        <div class="d-flex justify-content-end">
                            <a href="http://localhost/proyecto_final_ts1/?c=publicacion&a=Nueva&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>&idP=<?= $e->id ?>" class="btn btn-default">
                                <i class="bi bi-pencil" style="font-size: 1.5rem;"></i> <!-- Ajusta el tamaño según tus necesidades -->
                            </a>
                        </div>


                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>