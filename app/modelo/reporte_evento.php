<?php

require_once "modelo/db.php";

class ReporteEvento
{
    private $pdo;
    private $usuario_reportador; //int
    private $id_evento; //int
    private $motivo; //string
    private $estado; //string

    public function __construct()
    {
        try {
            $this->pdo = Db::conectar();
        } catch (Exception $e) {
            die('Error al conectar con la base de datos: ' . $e->getMessage());
        }
    }

    public function inserarNuevoReporteEvento(int $idEvento, int $idUsuario, string $motivo)
    {
        try {
            $query = $this->pdo->prepare("insert into reporte_eventos(id_evento,id_usuario_reportador,motivo,estado) values (?,?,?,?);");
            $query->execute(array($idEvento, $idUsuario, $motivo, 'PENDIENTE'));
            return true;
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }

    public function getReportesEventos()
    {
        try {
            $query = $this->pdo->prepare("CALL obtener_reportes_eventos();");
            $query->execute(array());
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }

    public function aceptarReporteEvento(int $idP, int $idUR)
    {
        try {
            $query = $this->pdo->prepare("CALL aceptar_reporte_evento(?,?);");
            $query->execute(array($idP, $idUR));
            return true;
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }

    public function getUsuarioReportador(): int
    {
        return $this->usuario_reportador;
    }

    public function setUsuarioReportador(int $usuario_reportador): void
    {
        $this->usuario_reportador = $usuario_reportador;
    }

    // Getter y Setter para $id_evento
    public function getIdEvento(): int
    {
        return $this->id_evento;
    }

    public function setIdEvento(int $id_evento): void
    {
        $this->id_evento = $id_evento;
    }

    // Getter y Setter para $motivo
    public function getMotivo(): string
    {
        return $this->motivo;
    }

    public function setMotivo(string $motivo): void
    {
        $this->motivo = $motivo;
    }

    // Getter y Setter para $estado
    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }
}
