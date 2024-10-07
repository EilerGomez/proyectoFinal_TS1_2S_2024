<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicaciones</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            <h1>Mis publicaciones</h1>
            <div>
                <a href="http://localhost/proyecto_final_ts1/?c=publicacion&a=Home&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>" class="mr-3">
                    <i class="fas fa-home notification-icon"></i>
                </a>
                <a href="#" class="mr-3">
                    <i class="fas fa-bell notification-icon"></i>
                </a>
                <a href="http://localhost/proyecto_final_ts1/?c=publicacion&a=Nueva&n=<?= $n ?>&rol=<?= $rol ?>&id=<?= $id ?>">
                    <i class="fas fa-plus notification-icon"></i> <!-- Icono de más -->
                </a>
                <a href="http://localhost/proyecto_final_ts1/?c=login&a=LogOut" class="ml-3">
                    <i class="fas fa-sign-out-alt notification-icon"></i> <!-- Icono de log out -->
                </a>
            </div>

        </header>
    </div>