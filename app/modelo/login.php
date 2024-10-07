<?php
require_once "modelo/db.php";
require_once "modelo/usuario.php";

class Login
{

    private $pdo;

    private $idUser;
    private $password;
    private $rol;

    public function __construct()
    {
        try {
            $this->pdo = Db::conectar();
        } catch (Exception $e) {
            die('Error al conectar con la base de datos: ' . $e->getMessage());
        }
    }

    public function getUserLogin(int $idUser, string $pass, int $rol)
    {
        try {
            $query = $this->pdo->prepare("call obtener_usuario(?,?,?);");
            $query->execute(array($idUser, $pass, $rol));
            $r = $query->fetch(PDO::FETCH_OBJ); //solo trae una por eso fetch
            if ($r === false) {
                return null; // No se encontró el usuario
            }
            $u = new Usuario();
            $u->setId($r->id);
            $u->setNombres(($r->nombres));
            $u->setApellidos($r->apellidos);
            $u->setTelefono($r->telefono);
            $u->setRol($r->rol);
            $u->setEdad($r->edad);
            $u->setPermisoPublicar($r->permiso_publicar);
            return $u;
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }
}
