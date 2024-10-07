<?php
require_once "modelo/usuario.php";
class UsuarioControlador
{

    private $modeloUsuarios;
    public function __construct()
    {
        $this->modeloUsuarios = new Usuario();
    }

    public function GuardarUsuario()
    {
        if (isset($_POST['nombres'], $_POST['apellidos'], $_POST['telefono'], $_POST['edad'], $_POST['rol'], $_POST['password2'])) {
            $us = $this->modeloUsuarios->guardarUsuario($_POST['nombres'], $_POST['apellidos'], (int)$_POST['telefono'], (int)$_POST['rol'], (int)$_POST['edad'], $_POST['password2']);
            echo "<script>
                        localStorage.setItem('usuario', JSON.stringify(" . json_encode($us) . "));

                        console.log('Usuario guardado en localStorage:', " . json_encode($us) . ");
                        setTimeout(() => {
                        window.location.href = 'controlador/dashboard.php';
                        }, 100); // 100 ms de retraso
                    </script>";
            exit();
        } else {
            $this->mostrarAlertCamposObligatorios();
        }
    }

    private function mostrarAlertCamposObligatorios(): void
    {
        echo "<script>
            alert('Ingrese todos los campos');
        </script>";
        exit(); // Asegúrate de detener la ejecución del script aquí
    }
}
