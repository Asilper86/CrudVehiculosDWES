<?php


use App\db\Usuario;
use App\db\Vehiculo;
require __DIR__."/../vendor/autoload.php";
Usuario::deleteAll();
Usuario::crearUsuarios(10);
Vehiculo::crearVehiculo(10);
echo "\nDatos creados.....";