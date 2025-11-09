<?php
namespace App\utils;

use App\db\Usuario;

class Validacion {
    //VALIDACIONES QUE NECESITO:
    // Usuario:
    /*  
        limpiarCadenas(),
        emailValido(),
        longitudCadena($nombreCampo, $valor, $min, $max);
        logValido,
        pintarErrores()
    */
    public static function limpiarCadenas(string $cad):string{
        return htmlspecialchars(trim($cad));
    }

    public static function emailValido(string $email):bool{
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        $_SESSION['err_email']="*** Error, formato de email inválido.";
        return false;
    }

    public static function longitudCadena(string $nombreCampo, string $valor, int $min, int $max):bool{
        if(strlen($valor) < $min || strlen($valor) > $max){
            $_SESSION["err_$nombreCampo"]="*** Error la longitud de $nombreCampo esperada es de $min caracteres minimo y $max maximo.";
            return false;
        }
        return true;
    }

    public static function rangoValidoNumerico(string $valor, string $nombreCampo, float $min, float $max):bool{
        if($valor < $min || $valor > $max){
            $_SESSION["err_$nombreCampo"]="*** Error, el $nombreCampo tiene que tener entre $min y $max caracteres";
            return false;
        }
        return true;
    }

    public static function tipoValido(string $valor):bool{
        if(in_array($valor, ['Coche', 'Moto', 'Camión', 'Furgoneta', 'Otro'])) return true;
        $_SESSION['err_tipo'] = "*** Error en el tipo seleccionado.";
        return false;
    }

    public static function logValido(string $email, string $password){
        if(!Usuario::validarUsuario($email, $password)){
            $_SESSION['err_validacion']="*** Error, email o contraseña son incorrectos.";
            return false;
        }
        return true;
    }

    public static function pintarErrores(string $nombre):void{
        if(isset($_SESSION[$nombre])){
            echo "<p class='text-red-500 mt-1 italic text-sm'>{$_SESSION[$nombre]}</p>";
            unset($_SESSION[$nombre]);
        }
    }
}