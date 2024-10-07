<?php

require_once "modelo/db.php";

class Evento
{

    private $pdo;

    private $id; //int
    private $id_usuario; //int
    private $lugar; //string
    private $fecha; //string
    private $hora; //string
    private $cupo_limitado; //int
    private $cupo_restante; //int
    private $url; //string
    private $tipo_publico; //string
    private $publicacion_automatica; //boolean
    private $aprobacion; //boolean
    private $estado; //string
    private $imagen; //string

    public function __construct()
    {
        try {
            $this->pdo = Db::conectar();
        } catch (Exception $e) {
            die('Error al conectar con la base de datos: ' . $e->getMessage());
        }
    }

    public function guardarEvento(int $id_usuario, string $lugar, string $fecha, string $hora, int $cupo_limitado, int $cupo_restante, string $url, string $tipo_publico, string $imagen): void
    {
        try {
            $query = $this->pdo->prepare("CALL guardar_evento(?, ?, ?, ?, ?, ?, ?, ?);");

            $query->execute(array($id_usuario, $lugar, $fecha, $hora, $cupo_limitado, $url, $tipo_publico, $imagen));
        } catch (Exception $th) {
            // Manejar excepciones y errores
            die($th->getMessage());
        }
    }

    public function traerEventos(int $iduser)
    {
        try {
            $query = $this->pdo->prepare("SELECT * FROM eventos where id_usuario=? order by id desc;");
            $query->execute(array($iduser));
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getIdUsuario(): ?int
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(int $id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    public function getLugar(): ?string
    {
        return $this->lugar;
    }

    public function setLugar(string $lugar): void
    {
        $this->lugar = $lugar;
    }

    public function getFecha(): ?string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getHora(): ?string
    {
        return $this->hora;
    }

    public function setHora(string $hora): void
    {
        $this->hora = $hora;
    }

    public function getCupoLimitado(): ?int
    {
        return $this->cupo_limitado;
    }

    public function setCupoLimitado(int $cupo_limitado): void
    {
        $this->cupo_limitado = $cupo_limitado;
    }

    public function getCupoRestante(): ?int
    {
        return $this->cupo_restante;
    }

    public function setCupoRestante(int $cupo_restante): void
    {
        $this->cupo_restante = $cupo_restante;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getTipoPublico(): ?string
    {
        return $this->tipo_publico;
    }

    public function setTipoPublico(string $tipo_publico): void
    {
        $this->tipo_publico = $tipo_publico;
    }

    public function isPublicacionAutomatica(): ?bool
    {
        return $this->publicacion_automatica;
    }

    public function setPublicacionAutomatica(bool $publicacion_automatica): void
    {
        $this->publicacion_automatica = $publicacion_automatica;
    }

    public function isAprobacion(): ?bool
    {
        return $this->aprobacion;
    }

    public function setAprobacion(bool $aprobacion): void
    {
        $this->aprobacion = $aprobacion;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }
}
