<?php

class Usuario implements JsonSerializable
{
    private $pdo; // objeto de conexión

    private int $id;
    private string $nombres;
    private string $apellidos;
    private int $telefono;
    private int $rol;
    private string $password;
    private int $edad;
    private float $permiso_publicar; // double en PHP es float

    // Constructor
    public function __construct()
    {
        try {
            $this->pdo = Db::conectar();
        } catch (Exception $e) {
            die('Error al conectar con la base de datos: ' . $e->getMessage());
        }
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function getRol(): ?int
    {
        return $this->rol;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getEdad(): ?int
    {
        return $this->edad;
    }

    public function getPermisoPublicar(): ?float
    {
        return $this->permiso_publicar;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNombres(string $nombres): void
    {
        $this->nombres = $nombres;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function setTelefono(int $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function setRol(int $rol): void
    {
        $this->rol = $rol;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setEdad(int $edad): void
    {
        $this->edad = $edad;
    }

    public function setPermisoPublicar(float $permiso_publicar): void
    {
        $this->permiso_publicar = $permiso_publicar;
    }

    // Implementación de JsonSerializable
    public function jsonSerialize(): array // Cambia el tipo de retorno a mixed
    {
        return [
            'id' => $this->id,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'telefono' => $this->telefono,
            'rol' => $this->rol,
            'edad' => $this->edad,
            'permiso_publicar' => $this->permiso_publicar,
        ];
    }

    public function guardarUsuario(string $nombres, string $apellidos, int $telefono, int $rol, int $edad, string $password)
    {
        try {
            $query = $this->pdo->prepare("CALL guardar_usuario(?, ?, ?, ?, ?, ?);");

            $query->execute(array($nombres, $apellidos, $telefono, $rol, $edad, $password));

            $r = $query->fetch(PDO::FETCH_OBJ);

            // Verificar si no se devolvió ningún resultado
            if ($r === false) {
                return null;
            }

            $u = new Usuario();
            $u->setId($r->id);
            $u->setNombres($r->nombres);
            $u->setApellidos($r->apellidos);
            $u->setTelefono($r->telefono);
            $u->setRol($r->rol);
            $u->setEdad($r->edad);
            $u->setPermisoPublicar($r->permiso_publicar);

            return $u;
        } catch (Exception $th) {
            // Manejar excepciones y errores
            die($th->getMessage());
        }
    }
}
