<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ola k hace</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb7O2l4lU6q41a6PHgSfT2Nhb5pDr8xDH9+n2" crossorigin="anonymous">

    <style>
        body {
            background-color: #f0f2f5;
        }

        .post {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .notification-icon {
            font-size: 24px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h1>Ola k hace</h1>
            <div>
                <!-- Icono de publicación -->
                <a href="http://localhost/proyecto_final_ts1/?c=admin&a=Publicaciones&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>" class="mr-3" title="Publicaciones">
                    <i class="fas fa-newspaper notification-icon"></i> <!-- Icono de publicación -->
                </a>

                <!-- Icono de reportes -->
                <a href="http://localhost/proyecto_final_ts1/?c=admin&a=ReportesEventos&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>" class="mr-3" title="Reportes">
                    <i class="fas fa-file-alt notification-icon"></i> <!-- Icono de reportes -->
                </a>

                <!-- Icono de usuarios -->
                <a href="http://localhost/proyecto_final_ts1/?c=admin&a=Usuarios&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>" class="mr-3" title="Usuarios">
                    <i class="fas fa-users notification-icon"></i> <!-- Icono de usuarios -->
                </a>

                <!-- Icono de log out -->
                <a href="http://localhost/proyecto_final_ts1/?c=login&a=LogOut" title="Cerrar sesión">
                    <i class="fas fa-sign-out-alt notification-icon"></i> <!-- Icono de log out -->
                </a>
            </div>


        </header>
    </div>