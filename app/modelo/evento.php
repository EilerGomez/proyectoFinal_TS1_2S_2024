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
    private $descripcion; //string
    private $usuarioPublicador; //string

    public function __construct()
    {
        try {
            $this->pdo = Db::conectar();
        } catch (Exception $e) {
            die('Error al conectar con la base de datos: ' . $e->getMessage());
        }
    }

    public function guardarEvento(
        int $id_usuario,
        string $lugar,
        string $fecha,
        string $hora,
        int $cupo_limitado,
        int $cupo_restante,
        string $url,
        string $tipo_publico,
        string $imagen,
        string $descripcion
    ): void {
        try {
            $query = $this->pdo->prepare("CALL guardar_evento(?, ?, ?, ?, ?, ?, ?, ?, ?);");

            $query->execute(array(
                $id_usuario,
                $lugar,
                $fecha,
                $hora,
                $cupo_limitado,
                $url,
                $tipo_publico,
                $imagen,
                $descripcion
            ));
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

    public function traerEventosPublicados(int $idP, int $idU)
    {
        try {
            $query = $this->pdo->prepare("CALL obtener_eventos_publicados(?,?);");
            $query->execute(array($idP, $idU));
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }
    public function traerNotificaciones(int $iduser)
    {
        try {
            $query = $this->pdo->prepare("SELECT * FROM notificaciones where id_usuario=? order by id desc;");
            $query->execute(array($iduser));
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }
    public function getEventoById(int $id): Evento
    {
        try {
            // Preparar la consulta SQL para obtener el evento por su ID
            $query = $this->pdo->prepare("SELECT * FROM eventos WHERE id = ?;");
            $query->execute([$id]);
            $r = $query->fetch(PDO::FETCH_OBJ); // Obtener solo un registro, por eso se usa fetch

            // Crear una instancia de Evento y asignar los valores recuperados
            $e = new Evento();
            $e->setId($r->id);
            $e->setIdUsuario($r->id_usuario);
            $e->setLugar($r->lugar);
            $e->setFecha($r->fecha);
            $e->setHora($r->hora);
            $e->setCupoLimitado($r->cupo_limitado);
            $e->setCupoRestante($r->cupo_restante);
            $e->setUrl($r->url);
            $e->setTipoPublico($r->tipo_publico);
            $e->setPublicacionAutomatica($r->publicacion_automatica);
            $e->setAprobacion($r->aprobacion);
            $e->setEstado($r->estado);
            $e->setImagen($r->imagen);
            $e->setDescripcion($r->descripcion);

            return $e;
        } catch (Exception $th) {
            // Manejar la excepción en caso de error
            die($th->getMessage());
        }
    }

    public function actualizarEvento(
        int $id,
        int $id_usuario,
        string $lugar,
        string $fecha,
        string $hora,
        int $cupo_limitado,
        string $url,
        string $tipo_publico,
        string $imagen, // Puedes pasar 'null' si es necesario
        string $descripcion
    ) {
        try {
            // Llamada directa al procedimiento que actualiza el evento
            $query = $this->pdo->prepare("
                CALL actualizar_evento(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
            ");

            // Ejecuta el procedimiento con los parámetros proporcionados
            $query->execute(array(
                $id,
                $id_usuario,
                $lugar,
                $fecha,
                $hora,
                $cupo_limitado,
                $url,
                $tipo_publico,
                $imagen, // Pasa el valor de la imagen, incluso si es 'null'
                $descripcion
            ));
        } catch (Exception $th) {
            // Manejo de excepciones en caso de error
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
    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }
    public function getUsuarioPublicador(): ?string
    {
        return $this->usuarioPublicador;
    }

    public function setUsuarioPublicador(string $usuarioPublicador): void
    {
        $this->usuarioPublicador = $usuarioPublicador;
    }
}
