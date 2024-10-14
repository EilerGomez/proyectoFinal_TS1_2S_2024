<?php
require_once "modelo/db.php";

class Usuario implements JsonSerializable
{
    private $pdo; // objeto de conexión

    private  $id;
    private  $nombres;
    private  $apellidos;
    private  $telefono;
    private  $rol;
    private  $password;
    private  $edad;
    private  $permiso_publicar; // double en PHP es float

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

    public function getUsuarios()
    {
        try {
            $query = $this->pdo->prepare("SELECT * FROM usuarios;");
            $query->execute(array());
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }

    public function getUsuarioById(int $idU): Usuario
    {
        try {
            // Preparar la consulta SQL para obtener el usuario por su ID
            $query = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ?;");
            $query->execute([$idU]);
            $r = $query->fetch(PDO::FETCH_OBJ); // Obtener solo un registro, por eso se usa fetch

            // Comprobar si se encontró un usuario
            if (!$r) {
                throw new Exception("Usuario no encontrado."); // Manejar el caso si no se encuentra el usuario
            }

            // Crear una instancia de Usuario y asignar los valores recuperados
            $usuario = new Usuario();
            $usuario->setId($r->id);
            $usuario->setNombres($r->nombres);
            $usuario->setApellidos($r->apellidos);
            $usuario->setTelefono($r->telefono);
            $usuario->setRol($r->rol);
            $usuario->setEdad($r->edad);
            $usuario->setPermisoPublicar($r->permiso_publicar);
            // Si tienes otros métodos de setter, añádelos aquí

            return $usuario;
        } catch (Exception $th) {
            // Manejar la excepción en caso de error
            die($th->getMessage());
        }
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

    public function guardarUsuarioDeAdmin(string $nombres, string $apellidos, int $telefono, int $rol, int $edad, string $password, int $permiso_publicar)
    {

        try {
            $query = $this->pdo->prepare("INSERT INTO usuarios (nombres, apellidos, telefono, rol, password, edad, permiso_publicar)
                                                VALUES (?, ?, ?, ?, ?, ?, ?);");
            $query->execute(array($nombres, $apellidos, $telefono, $rol, $password, $edad, $permiso_publicar));
            return true;
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }

    public function actualizarUsuario(int $idU, string $nombres, string $apellidos, int $telefono, int $rol, int $edad, string $password, int $permiso_publicar)
    {
        try {
            $query = $this->pdo->prepare("UPDATE usuarios SET nombres=?, apellidos=?, telefono=?, rol=?, password=?, edad=?, permiso_publicar=?
                                                WHERE id = ? ;");
            $query->execute(array($nombres, $apellidos, $telefono, $rol, $password, $edad, $permiso_publicar, $idU));
            return true;
        } catch (Exception $th) {
            die($th->getMessage());
        }
    }
}
