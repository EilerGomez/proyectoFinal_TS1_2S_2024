<div class="container mt-4">
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
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <button class="dropdown-item" type="button">Deseo asistir</button>
                                    <button class="dropdown-item" type="button">Denunciar publicación</button>
                                </div>
                            </div>
                        </div>

                        <p class="mt-2">
                            Lugar: <strong><?= $e->lugar ?></strong> <br>
                            Público: <?= $e->tipo_publico === 'T' ? 'Todos' : ($e->tipo_publico === 'ME' ? 'Menores de edad' : 'Mayores de edad') ?>
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

                        <p class="text-muted">
                            Estado del evento: <strong><?= $e->estado ?></strong>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>


    </div>
</div>