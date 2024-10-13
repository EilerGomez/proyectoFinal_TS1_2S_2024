<?php
require_once "modelo/usuario.php";
require_once "modelo/evento.php";
require_once "modelo/usuario_evento.php";
require_once "modelo/reporte_evento.php";

class UsuarioregistradoControlador
{
    private $modeloEvento;
    private $modeloUsuarioEvento;
    private $modeloReporteEvento;

    public function __construct()
    {
        $this->modeloEvento = new Evento();
        $this->modeloUsuarioEvento = new UsuarioEvento();
        $this->modeloReporteEvento = new ReporteEvento();
    }

    public function Inicio()
    {
        //echo $this->usuario;
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $this->llavedeAcceso((int)$_GET['rol']);
        require_once "vista/areaUsuarioRegistrado/header.php";
        require_once "vista/areaUsuarioRegistrado/publicaciones/todas.php"; // Aquí es donde usas $name
        require_once "vista/areaUsuarioRegistrado/foot.php";
    }

    public function NotificacionesEventos()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $this->llavedeAcceso((int)$_GET['rol']);
        require_once "vista/areaUsuarioRegistrado/header.php";
        require_once "vista/areaUsuarioRegistrado/publicaciones/eventos_asignados.php"; // Aquí es donde usas $name
        require_once "vista/areaUsuarioRegistrado/foot.php";
    }

    public function Reportar()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $idP = $_GET['idP'];
        $this->llavedeAcceso((int)$_GET['rol']);
        $pr = $this->modeloEvento->getEventoById($idP);
        require_once "vista/areaUsuarioRegistrado/header.php";
        require_once "vista/areaUsuarioRegistrado/publicaciones/reportar.php";
        require_once "vista/areaUsuarioRegistrado/foot.php";
    }

    public function RealizarReporte()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $idP = $_POST['idP'];
        $this->llavedeAcceso((int)$_GET['rol']);
        $this->modeloReporteEvento->inserarNuevoReporteEvento((int)$idP, (int)$id, $_POST['motivo']);
        $this->mostrarAletraExitoGuardadoReporteEvento($n, (int)$rol, (int)$id, "Reporte hecho correctamente!!");
    }

    public function PreguntarAsistir()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $idp = $_GET['idP'];
        $usuarioNotificacion = $_GET['idNot'];
        $descripcion = $_GET['descripcionP'];
        $cupoRestante = $_GET['cupoRestante'];
        $this->llavedeAcceso((int)$_GET['rol']);
        $this->Asistir((int)$id, (int)$idp, $descripcion, (int)$usuarioNotificacion, $n, (int)$cupoRestante);
    }

    public function PreguntarDesasistir()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $idp = $_GET['idP'];
        $usuarioNotificacion = $_GET['idNot'];
        $descripcion = $_GET['descripcionP'];
        $this->llavedeAcceso((int)$_GET['rol']);
        $this->DesAsistir((int)$id, (int)$idp, $descripcion, (int)$usuarioNotificacion, $n);
    }

    public function Asistir(int $idUser, int $idP, string $descripcion, int $usarioNotificacion, string $n, int $cupoRestante)
    {
        if ($cupoRestante > 0) {
            $this->modeloUsuarioEvento->insertarUsuarioEvento($idUser, $idP);
            $this->modeloUsuarioEvento->insertarNotificacionAsistir($usarioNotificacion, $n, $descripcion);
            header('Location: controlador/dashboard.php');
            exit();
        } else {
            echo "<script>
                alert('No existe más cupo');
                window.location.href = 'controlador/dashboard.php';
            </script>";
            exit();
        }
    }
    public function DesAsistir(int $idUser, int $idP, string $descripcion, int $usarioNotificacion, string $n)
    {
        $this->modeloUsuarioEvento->eliminarUsuarioEvento($idUser, $idP);
        $this->modeloUsuarioEvento->insertarNotificacionDesAsistir($usarioNotificacion, $n, $descripcion);
        header('Location: controlador/dashboard.php');
        exit();
    }

    public function llavedeAcceso(int $rol)
    {
        if ($rol !== 3) {
            header('Location: controlador/dashboard.php');
            exit();
        }
    }
    private function mostrarAletraExitoGuardadoReporteEvento(string $n, int $rol, int $id, string $msj): void
    {
        echo "<script>
            alert('" . $msj . "');
            window.location.href = 'http://localhost/proyecto_final_ts1/?c=usuarioregistrado&a=Inicio&n=" . urlencode($n) . "&rol=" . $rol . "&id=" . $id . "';
        </script>";
        exit; // Asegúrate de salir para que no se ejecute más código.
    }
}
