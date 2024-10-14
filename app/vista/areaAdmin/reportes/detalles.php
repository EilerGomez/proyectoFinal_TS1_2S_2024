<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" type="text/css" href="http://localhost/proyecto_final_ts1/assets/css/main.css">

<div class="container">

    <div id="posts">
        <?php foreach ($this->modeloEvento1->traerEventosPublicados($idP, $id) as $e): ?>
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

                        <div class="text-end mt-4">
                            <button class="btn btn-default" type="button" onclick="window.history.back();">Volver</button>
                        </div>


                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>