<?php
namespace App\db;

use \PDOException;
use \PDOStatement;
use \PDO;
use stdClass;
class Vehiculo extends Conexion
{
    private int $id;
    private string $marca;
    private string $modelo;
    private int $usuario_id;
    private string $tipo;
    private string $descripcion;
    private float $precio;


    private static function executeQuery(string $q, array $parametros = [], bool $devolverAlgo = false)
    {
        $stmt = self::getConexion()->prepare($q);
        try {
            count($parametros) ? $stmt->execute($parametros) : $stmt->execute();
        } catch (PDOException $ex) {
            die("Error: " . $ex->getMessage());
        }
        if ($devolverAlgo)
            return $stmt;
    }

    public function create()
    {
        $q = "INSERT INTO Vehiculo (marca, modelo, tipo, precio, descripcion, usuario_id) 
          VALUES (:ma, :mo, :t, :p, :d, :ui)";

        self::executeQuery($q, [
            ':ma' => $this->marca,
            ':mo' => $this->modelo,
            ':t' => $this->tipo,
            ':p' => $this->precio,
            ':d' => $this->descripcion,
            ':ui' => $this->usuario_id
        ]);
    }

    public static function deleteAll(?int $id = null)
    {
        $q = ($id == null) ? "delete from Vehiculo" : "delete from Vehiculo where id=$id";
        self::executeQuery($q);
    }


    public static function read(): array
    {
        $q = "select Vehiculo.*, email from Vehiculo, Usuario where usuario_id=Usuario.id order by Vehiculo.id desc";
        $stmt = self::executeQuery($q, [], true);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function vehiculoPerteneceUsuario(int $idV, int $idU): bool
    {
        $q = "select id from Vehiculo where id=:iv and usuario_id=:iu";
        $stmt = self::executeQuery($q, [':iv' => $idV, ':iu' => $idU], true);
        $datos = $stmt->fetchAll(PDO::FETCH_OBJ);
        return count($datos);
    }

    public function update(int $id)
    {
        $q = "update Vehiculo set marca = :m, modelo = :mo, tipo = :t,precio = :p, descripcion = :d, usuario_id = :u WHERE id = :id";
        return self::executeQuery($q, [
            ':m' => $this->marca,
            ':mo' => $this->modelo,
            ':t' => $this->tipo,
            ':p' => $this->precio,
            ':d' => $this->descripcion,
            ':u' => $this->usuario_id,
            ':id' => $id
        ]);
    }



    public static function getVehiculoById(int $id): \stdClass
    {
        $q = "select * from Vehiculo where id=:i";
        $stmt = self::executeQuery($q, [':i' => $id], true);
        return ($stmt->fetchAll(PDO::FETCH_OBJ))[0];
    }
    public static function crearVehiculo(int $cantidad)
    {
        $faker = \Faker\Factory::create('es_ES');
        $idUsers = Usuario::devolverIds();
        for ($i = 0; $i < $cantidad; $i++) {
            $marca = ucfirst($faker->unique()->words(mt_rand(1, 7), true));
            $modelo = ucfirst($faker->unique()->words(mt_rand(1, 15), true));
            $tipo = $faker->randomElement(['Coche', 'Moto', 'Camión', 'Furgoneta', 'Otro']) ?? 'Coche';
            $usuario_id = $faker->randomElement($idUsers);
            $descripcion = $faker->sentence(mt_rand(15, 25));
            $precio = $faker->randomFloat(2, 10, 999999.99);
            (new Vehiculo())
                ->setMarca($marca)
                ->setModelo($modelo)
                ->setTipo($tipo)
                ->setUsuarioId($usuario_id)
                ->setDescripcion($descripcion)
                ->setPrecio($precio)
                ->create();
        }

    }



    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
    public function getMarca(): string
    {
        return $this->marca;
    }
    public function setMarca(string $marca): self
    {
        $this->marca = $marca;

        return $this;
    }
    public function getModelo(): string
    {
        return $this->modelo;
    }
    public function setModelo(string $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
    }
    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }
    public function setUsuarioId(int $usuario_id): self
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }
    public function getTipo(): string
    {
        return $this->tipo;
    }
    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }
    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }
    public function getPrecio(): float
    {
        return $this->precio;
    }
    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }
}