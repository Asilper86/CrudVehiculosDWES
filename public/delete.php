<?php

use App\db\Usuario;
use App\db\Vehiculo;
session_start();
require __DIR__."/../vendor/autoload.php";
$email = $_SESSION['email'];
$id_vehiculo = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if($id_vehiculo){
    $id=Usuario::devolverIds($email);
    $id_usuario=$id[0];
    if(!Vehiculo::vehiculoPerteneceUsuario($id_vehiculo, $id_usuario)){
        $_SESSION['mensaje']="Accion Prohibida!!";
        header("Location:menu.php");
        die();
    }

    Vehiculo::deleteAll($id_vehiculo);
    $_SESSION['mensaje']="Vehiculo Borrado.";
    header("Location:menu.php");
    die();
}