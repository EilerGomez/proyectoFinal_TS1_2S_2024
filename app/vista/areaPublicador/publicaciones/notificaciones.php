<div class="container">
    <h1>Notificaciones de <?= htmlspecialchars($n) ?></h1>
    <div id="posts">

        <div class="mt-4">
            <h3>Notificaciones</h3>
            <?php foreach ($this->modeloEvento->traerNotificaciones((int)$id) as $n): ?>
                <div class="post">
                    <p><strong><?= $n->name_usuario ?></strong> <?= $n->descripcion ?>.</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>