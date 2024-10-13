<?php

require_once "modelo/db.php";

class UsuarioEvento
{
    private $pdo;
    public function __construct()
    {
        try {
            $this->pdo = Db::conectar();
        } catch (Exception $e) {
            die('Error al conectar con la base de datos: ' . $e->getMessage());
        }
    }

    public function insertarUsuarioEvento(int $iduser, int $idP)
    {
        try {
            $query = $this->pdo->prepare("insert into usuario_evento(id_evento, id_usuario) values (?,?);");
            $query->execute(array($idP, $iduser));
            $query = $this->pdo->prepare("update eventos set cupo_restante = cupo_restante - 1 where id=?");
            $query->execute(array($idP));
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }

    public function eliminarUsuarioEvento(int $iduser, int $idP)
    {
        try {
            $query = $this->pdo->prepare("delete from usuario_evento where id_evento = ? and id_usuario=?;");
            $query->execute(array($idP, $iduser));
            $query = $this->pdo->prepare("update eventos set cupo_restante = cupo_restante + 1 where id=?");
            $query->execute(array($idP));
            return true;
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }

    public function insertarNotificacionAsistir(int $usuarioNotificacion, string $n, string $descripcionPublicacion)
    {
        try {
            $descripcion = "Se ha asignado a tu evento: " . $descripcionPublicacion . ".";
            $query = $this->pdo->prepare("insert into notificaciones(id_usuario, name_usuario, descripcion) values (?,?,?);");
            $query->execute(array($usuarioNotificacion, $n, $descripcion));
            return true;
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }
    public function insertarNotificacionDesAsistir(int $usuarioNotificacion, string $n, string $descripcionPublicacion)
    {
        try {
            $descripcion = "Se ha desasignado de tu evento: " . $descripcionPublicacion . ".";
            $query = $this->pdo->prepare("insert into notificaciones(id_usuario, name_usuario, descripcion) values (?,?,?);");
            $query->execute(array($usuarioNotificacion, $n, $descripcion));
            return true;
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }

    public function traerEventoUsuario(int $idU)
    {
        try {
            $query = $this->pdo->prepare("CALL obtener_usuario_evento(?);");
            $query->execute(array($idU));
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }
}
