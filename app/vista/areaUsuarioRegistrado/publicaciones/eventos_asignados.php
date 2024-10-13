<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<div class="container">
    <h1>Notificaciones de eventos</h1>

    <div id="posts">
        <?php foreach ($this->modeloUsuarioEvento->traerEventoUsuario($id) as $e): ?>
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
                                <strong>Publicado por:</strong> <?= $e->usuarioPublicador ?><br>
                                <!-- Calcular y mostrar el tiempo restante -->
                                <?php
                                $fechaEvento = new DateTime($e->fecha); // La fecha del evento
                                $hoy = new DateTime(); // La fecha actual
                                $intervalo = $hoy->diff($fechaEvento); // Calcular la diferencia
                                $diasRestantes = $intervalo->format('%r%a'); // Días restantes
                                ?>
                                <small class="text-muted">
                                    Tiempo restante: <?= $diasRestantes ?> día(s)
                                </small>
                            </div>
                        </div>

                        <!-- Mostrar la descripción del evento -->
                        <p class="mt-2">
                            <?= $e->descripcion ?>
                        </p>

                        <!-- Mostrar la imagen si está disponible -->
                        <?php if (!empty($e->imagen)): ?>
                            <img src="<?= $e->imagen ?>" class="img-fluid rounded mb-3" alt="Imagen del evento">
                        <?php endif; ?><br>

                        <!-- Botón para más información -->
                        <?php if (!empty($e->url)): ?>
                            <a href="<?= $e->url ?>" target="_blank" class="btn btn-primary">Más información</a>
                        <?php endif; ?>

                        <!-- Mostrar el estado del evento -->
                        <p class="text-muted mt-3">
                            <strong>Estado del evento:</strong> <?= $e->estado ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>