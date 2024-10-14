<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<div class="container">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Usuarios</h2>
            <!-- Botón de Agregar Usuario -->
            <a href="http://localhost/proyecto_final_ts1/?c=admin&a=NuevoUsuario&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>" class="btn btn-success">
                <i class="bi bi-person-plus"></i> Agregar Usuario
            </a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Edad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->modeloUsuarios->getUsuarios() as $usuario): ?>
                    <tr>
                        <td><?= $usuario->id ?></td>
                        <td><?= $usuario->nombres ?></td>
                        <td><?= $usuario->apellidos ?></td>
                        <td><?= $usuario->telefono ?></td>
                        <td>
                            <?php
                            switch ($usuario->rol) {
                                case 1:
                                    echo 'Admin';
                                    break;
                                case 2:
                                    echo 'Usuario Publicador';
                                    break;
                                case 3:
                                    echo 'Usuario Registrado';
                                    break;
                                default:
                                    echo 'Desconocido';
                            }
                            ?>
                        </td>
                        <td><?= $usuario->edad ?></td>
                        <td>
                            <!-- Botón para editar -->
                            <a href="http://localhost/proyecto_final_ts1/?c=admin&a=NuevoUsuario&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>&idU=<?= $usuario->id ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>