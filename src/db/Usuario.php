<?php
namespace App\db;
use \PDO;
use \PDOException;
use \PDOStatement;
use \Faker;
class Usuario extends Conexion
{
    private int $id;
    private string $email;
    private string $password;

    private static function executeQuery(string $q, array $parametros = [], bool $devolverAlgo = false)
    {
        $stmt = self::getConexion()->prepare($q);
        try {
            count($parametros) ? $stmt->execute($parametros) : $stmt->execute();
        } catch (PDOException $ex) {
            die("Error en la query: " . $ex->getMessage());
        }
        if ($devolverAlgo)
            return $stmt;

    }

    public function create()
    {
        $q = "insert into Usuario(email, password) values (:e, :p)";
        self::executeQuery($q, [':e' => $this->email, ':p' => $this->password], true);
    }

    public static function crearUsuarios(int $cant)
    {
        $faker = Faker\Factory::create('es_ES');
        for ($i = 0; $i < $cant; $i++) {
            $email = $faker->unique()->freeEmail();
            $password = "secret0";
            (new Usuario())->setEmail($email)
                ->setPassword($password)
                ->create();
        }
    }
    public static function deleteAll()
    {
        $q = "delete from Usuario";
        self::executeQuery($q);
    }

    public static function devolverIds(?string $email = null): array
    {
        $q = ($email == null) ? "select id from Usuario" : "select id from Usuario where email=:e";
        $parametros = ($email == null) ? [] : [':e' => $email];
        $stmt = self::executeQuery($q, $parametros, true);
        $filas = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($filas as $item) {
            $ids[] = $item->id;
        }
        return $ids;
    }

    public static function validarUsuario(string $email, string $password): bool
    {
        $q = "SELECT password FROM Usuario WHERE email = :e";
        $stmt = self::executeQuery($q, [':e' => $email], true);
        $variableAuxiliar = $stmt->fetch(PDO::FETCH_OBJ);
        // Validacion final
        // Si variableAuxiliar es true existe el email, password password_verify compara la contraseña escrita con el hash guardado
        return ($variableAuxiliar && password_verify($password, $variableAuxiliar->password));
    }


    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }
}