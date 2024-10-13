<?php

require_once "modelo/usuario.php";
require_once "modelo/evento.php";

class PublicacionControlador
{

    private $modeloEvento;

    public function __construct()
    {
        $this->modeloEvento = new Evento();
    }

    public function Inicio()
    {
        //echo $this->usuario;
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $this->llavedeAcceso((int)$_GET['rol']);
        require_once "vista/areaPublicador/header.php";
        require_once "vista/areaPublicador/foot.php";
    }
    public function Home()
    {

        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $this->llavedeAcceso((int)$_GET['rol']);
        require_once "vista/areaPublicador/header.php";
        require_once "vista/areaPublicador/publicaciones/todas.php"; // Aquí es donde usas $name
        require_once "vista/areaPublicador/foot.php";
    }

    public function Notifications()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $this->llavedeAcceso((int)$_GET['rol']);
        require_once "vista/areaPublicador/header.php";
        require_once "vista/areaPublicador/publicaciones/notificaciones.php"; // Aquí es donde usas $name
        require_once "vista/areaPublicador/foot.php";
    }

    public function Nueva()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $accion = "Guardar publicacion";
        $titulo = "Ingrese los datos para la nueva publicacion";
        $pe = new Evento();
        $pe->setId(0);
        if (isset($_GET['idP'])) {
            $pe = $this->modeloEvento->getEventoById((int)$_GET['idP']);
            $accion = "Actualizar publicacion";
            $titulo = "Ingrese los datos si desea modificar la publicacion";
        }
        $this->llavedeAcceso((int)$_GET['rol']);
        require_once "vista/areaPublicador/header.php";
        require_once "vista/areaPublicador/publicaciones/nueva.php";
        require_once "vista/areaPublicador/foot.php";
    }

    public function GuardarEvento()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $rutaImagen = $this->rutaDeImagen();

        if (isset(
            $_POST['lugar'],
            $_POST['fecha'],
            $_POST['hora'],
            $_POST['cupo'],
            $_POST['url'],
            $_POST['publico']
        )) {
            if (((int)$_POST['idP']) > 0) {
                $this->modeloEvento->actualizarEvento(
                    (int)$_POST['idP'],
                    (int)$id,
                    $_POST['lugar'],
                    $_POST['fecha'],
                    $_POST['hora'],
                    (int)$_POST['cupo'],
                    $_POST['url'],
                    $_POST['publico'],
                    $rutaImagen,
                    $_POST['descripcion']
                );
                $this->mostrarAletraExitoGuardadoEvento($n, $rol, $id, msj: "Evento actualizado correctamente");
            } else {
                // Guardar los datos en la base de datos
                $this->modeloEvento->guardarEvento(
                    (int)$id,
                    $_POST['lugar'],
                    $_POST['fecha'],
                    $_POST['hora'],
                    (int)$_POST['cupo'],
                    (int)$_POST['cupo'],
                    $_POST['url'],
                    $_POST['publico'],
                    $rutaImagen, // Guardar la ruta de la imagen en la base de datos
                    $_POST[(string)'descripcion']
                );

                // Mostrar un mensaje de éxito
                $this->mostrarAletraExitoGuardadoEvento($n, $rol, $id, "Evento guardado correctamente");
            }
        }
    }



    public function llavedeAcceso(int $rol)
    {
        if ($rol !== 2) {
            header('Location: controlador/dashboard.php');
            exit();
        }
    }

    public function rutaDeImagen(): string
    {
        // Verificar si se recibió una solicitud POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen'])) {
            $archivo = $_FILES['imagen'];

            // Obtener información del archivo
            $nombreArchivo = pathinfo($archivo['name'], PATHINFO_FILENAME);
            $extensionArchivo = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $rutaTemporal = $archivo['tmp_name'];
            $error = $archivo['error'];

            // Verificar si no hubo errores en la carga
            if ($error === UPLOAD_ERR_OK) {
                // Definir el directorio de destino relativo al directorio de imágenes públicas
                $directorioDestino = __DIR__ . '/../data/img/';
                $rutaRelativa = 'data/img/' . $nombreArchivo . '.' . $extensionArchivo;

                // Verifica si el directorio de destino existe, si no, lo crea
                if (!is_dir($directorioDestino)) {
                    if (!mkdir($directorioDestino, 0755, true)) {
                        error_log("No se pudo crear el directorio: " . $directorioDestino);
                        return "null";
                    }
                }

                // Ruta completa con el nombre del archivo
                $rutaImagen = $directorioDestino . $nombreArchivo . '.' . $extensionArchivo;

                // Si el archivo ya existe, agregar un contador al nombre
                $contador = 1;
                while (file_exists($rutaImagen)) {
                    $rutaImagen = $directorioDestino . $nombreArchivo . '(' . $contador . ').' . $extensionArchivo;
                    $rutaRelativa = 'data/img/' . $nombreArchivo . '(' . $contador . ').' . $extensionArchivo;
                    $contador++;
                }

                // Mover el archivo a la ubicación deseada
                if (move_uploaded_file($rutaTemporal, $rutaImagen)) {
                    error_log("Archivo guardado exitosamente en: " . $rutaImagen);
                    return $rutaRelativa; // Guardar la ruta relativa en la base de datos
                } else {
                    error_log("Error al mover el archivo a: " . $rutaImagen);
                    return "null";
                }
            } else {
                // Manejar errores en la carga
                error_log("Error en la carga de la imagen: " . $error);
                return "null";
            }
        }

        // Si no se envió el archivo, devuelve "null"
        error_log("No se envió ningún archivo.");
        return "null";
    }







    private function mostrarAletraExitoGuardadoEvento(string $n, int $rol, int $id, string $msj): void
    {
        echo "<script>
            alert('" . $msj . "');
            window.location.href = 'http://localhost/proyecto_final_ts1/?c=publicacion&a=Home&n=" . urlencode($n) . "&rol=" . $rol . "&id=" . $id . "';
        </script>";
        exit; // Asegúrate de salir para que no se ejecute más código.
    }
}
