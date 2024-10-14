<?php

require_once "modelo/usuario.php";
require_once "modelo/reporte_evento.php";
require_once "modelo/evento.php";


class AdminControlador
{
    private $modeloUsuarios;
    private $modeloReportesEvento; //este es el de reportes
    private $modeloEvento1;

    public function __construct()
    {
        $this->modeloUsuarios = new Usuario();
        $this->modeloReportesEvento =  new ReporteEvento();
        $this->modeloEvento1 =  new Evento();
    }

    public function Inicio()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $this->llavedeAcceso((int)$_GET['rol']);
        require_once "vista/areaAdmin/header.php";
        require_once "vista/areaAdmin/foot.php";
    }

    public function Publicaciones()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $this->llavedeAcceso((int)$_GET['rol']);
        require_once "vista/areaAdmin/header.php";
        require_once "vista/areaAdmin/publicaciones/todas.php";
        require_once "vista/areaAdmin/foot.php";
    }
    public function Usuarios()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $this->llavedeAcceso((int)$_GET['rol']);

        require_once "vista/areaAdmin/header.php";
        require_once "vista/areaAdmin/usuarios/todos.php";
        require_once "vista/areaAdmin/foot.php";
    }

    public function ReportesEventos()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $this->llavedeAcceso((int)$_GET['rol']);
        require_once "vista/areaAdmin/header.php";
        require_once "vista/areaAdmin/reportes/todos.php";
        require_once "vista/areaAdmin/foot.php";
    }

    public function DetallesEvento()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $idP = (int) $_GET['idP'];
        $this->llavedeAcceso((int)$_GET['rol']);
        require_once "vista/areaAdmin/header.php";
        require_once "vista/areaAdmin/reportes/detalles.php";
        require_once "vista/areaAdmin/foot.php";
    }

    public function AceptarReporteEvento()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $idP = (int) $_GET['idP'];
        $idUR = (int)$_GET['idUR'];
        $this->modeloReportesEvento->aceptarReporteEvento($idP, $idUR);
        header('Location: http://localhost/proyecto_final_ts1/?c=admin&a=ReportesEventos&n=' . $n . '&rol=' . $rol . '&id=' . $id);
        exit();
    }

    public function AprobarPublicacion()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $idP = (int) $_GET['idP'];
        $this->modeloEvento1->aprobarPublicacionAdmin($idP);
        header('Location: http://localhost/proyecto_final_ts1/?c=admin&a=Publicaciones&n=' . $n . '&rol=' . $rol . '&id=' . $id);
        exit();
    }

    public function NuevoUsuario()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $titulo = "Ingrese los datos para el nuevo usuario";
        $accion = "Guardar usuario";
        $u = new Usuario();
        $u->setId(0);
        if (isset($_GET['idU'])) {
            $titulo = "Ingrese los datos para modificar el usuario";
            $accion = "Actualizar usuario";
            $u =  $this->modeloUsuarios->getUsuarioById((int)$_GET['idU']);
        }
        $this->llavedeAcceso((int)$_GET['rol']);
        require_once "vista/areaAdmin/header.php";
        require_once "vista/areaAdmin/usuarios/nuevo.php";
        require_once "vista/areaAdmin/foot.php";
    }



    public function GuardarUsuario()
    {
        $n = $_GET['n'];
        $rol = $_GET['rol'];
        $id = $_GET['id'];
        $this->llavedeAcceso((int)$_GET['rol']);
        $permisoPublicar = isset($_POST['permiso_publicar']) ? 1 : 0;
        if (isset($_POST['idU']) && (int)$_POST['idU'] > 0) {
            $this->modeloUsuarios->actualizarUsuario(
                (int)$_POST['idU'],
                $_POST['nombres'],
                $_POST['apellidos'],
                (int)$_POST['telefono'],
                (int)$_POST['rol'],
                (int)$_POST['edad'],
                $_POST['password1'],
                $permisoPublicar
            );
            $this->mostrarAletraExitoGuardadoUsuario($n, $rol, $id, "Usuario actualizado corectamente!!");
        } else {
            $this->modeloUsuarios->guardarUsuarioDeAdmin(
                $_POST['nombres'],
                $_POST['apellidos'],
                (int)$_POST['telefono'],
                (int)$_POST['rol'],
                (int)$_POST['edad'],
                $_POST['password1'],
                $permisoPublicar
            );
            $this->mostrarAletraExitoGuardadoUsuario($n, $rol, $id, "Usuario guardado corectamente!!");
        }
    }

    public function llavedeAcceso(int $rol)
    {
        if ($rol !== 1) {
            header('Location: controlador/dashboard.php');
            exit();
        }
    }
    private function mostrarAletraExitoGuardadoUsuario(string $n, int $rol, int $id, string $msj): void
    {
        echo "<script>
            alert('" . $msj . "');
            window.location.href = 'http://localhost/proyecto_final_ts1/?c=admin&a=Usuarios&n=" . urlencode($n) . "&rol=" . $rol . "&id=" . $id . "';
        </script>";
        exit; // Asegúrate de salir para que no se ejecute más código.
    }
}
