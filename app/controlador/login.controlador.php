<?php

require_once "modelo/login.php";
require_once "modelo/usuario.php";

class LoginControlador
{
    private $modeloLogin;

    public function __construct()
    {
        $this->modeloLogin = new Login();
    }

    public function Inicio()
    {
        require_once "vista/login/login.php";
    }

    public function Loguearse()
    {
        if (isset($_POST['userId'], $_POST['password'], $_POST['role'])) {
            $u = $this->modeloLogin->getUserLogin((int)$_POST['userId'], $_POST['password'], (int)$_POST['role']);
            if ($u === null) {
                $this->mostrarAlertaNoExisteUsuario();
            } else {
                // Aquí manejas el inicio de sesión exitoso
                echo "<script>
                        localStorage.setItem('usuario', JSON.stringify(" . json_encode($u) . "));

                        console.log('Usuario guardado en localStorage:', " . json_encode($u) . ");
                        setTimeout(() => {
                        window.location.href = 'controlador/dashboard.php';
                        }, 100); // 100 ms de retraso
                    </script>";
                exit();
            }
        } else {
            $this->Inicio(); // Redirige al formulario de inicio de sesión si no se han enviado los datos
        }
    }

    public function LogOut()
    {
        echo "<script>
        if (confirm('¿Está seguro que desea cerrar sesión?')) {
            // Eliminar el item del localStorage
            localStorage.removeItem('usuario');
            console.log('Usuario eliminado de localStorage');
            
            // Reemplazar la entrada actual del historial
            history.replaceState(null, null, window.location.href);
            
            // Redirigir a la página del dashboard
            window.location.href = 'controlador/dashboard.php';
        } else {
            // Si el usuario cancela, solo imprimir un mensaje en la consola
            console.log('Cierre de sesión cancelado');
        }
    </script>";
        exit();
    }





    private function mostrarAlertaNoExisteUsuario(): void
    {
        echo "<script>
            alert('No existe el usuario.');
            window.location.href = '?c=login'; // Redirige a la página de login
        </script>";
        exit(); // Asegúrate de detener la ejecución del script aquí
    }
}
