<?php
namespace App\db;
use \PDO;
use \PDOException;
use \Dotenv\Dotenv;
class Conexion{
    private static ?PDO $conexion = null;

    protected static function getConexion(){
        if(self::$conexion == null){
            self::setConexion();
        }
        return self::$conexion;
    }
    private static function setConexion(){
        $dotenv = Dotenv::createImmutable(__DIR__."/../../");
        $dotenv->load();
        $usuario = $_ENV['USUARIO'];
        $password = $_ENV['PASSWORD'];
        $puerto = $_ENV['PUERTO'];
        $db = $_ENV['DATABASE'];
        $host = $_ENV['HOST'];

        $dsn = "mysql:host=$host;dbname=$db;port=$puerto;charset=utf8mb4";
        $opciones = [
            PDO::ATTR_PERSISTENT=>true,
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES=>false
        ];

        try{
            self::$conexion = new PDO($dsn,  $usuario, $password, $opciones);
        } catch (PDOException $ex){
            die("Error en la conexion: ".$ex->getMessage());
        }
    }
}