<?php

use App\db\Usuario;
use App\db\Vehiculo;
use App\utils\Validacion;
session_start();
require __DIR__ . "/../vendor/autoload.php";
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
    die();
}
$email = $_SESSION['email'];
if (isset($_POST['marca'])) {
    //1.- Recoger y limpiar los campos del formulario
    $marca = Validacion::limpiarCadenas($_POST['marca']);
    $modelo = Validacion::limpiarCadenas($_POST['modelo']);
    $tipo = $_POST['tipo'] ?? "Error";
    $tipo = Validacion::limpiarCadenas($tipo);
    $precio = Validacion::limpiarCadenas($_POST['precio']);
    $precio = (float) $precio;
    $descripcion = Validacion::limpiarCadenas($_POST['descripcion']);
    // --------------------------
    $errores = false;
    if (!Validacion::longitudCadena('marca', $marca, 3, 100)) {
        $errores = true;
    }
    if (!Validacion::longitudCadena('modelo', $modelo, 3, 100)) {
        $errores = true;
    }
    if (!Validacion::longitudCadena('descripcion', $descripcion, 3, 500)) {
        $errores = true;
    }
    if (!Validacion::rangoValidoNumerico($precio, 'precio', 10, 99999.99)) {
        $errores = true;
    }
    if (!Validacion::tipoValido($tipo)) {
        $errores = true;
    }
    // si hay errores
    if ($errores) {
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
    }
    // si no hay errores, guardamos el producto;
    $id_usuario = Usuario::devolverIds($email);
    (new Vehiculo())->setMarca($marca)
        ->setModelo($modelo)
        ->setTipo($tipo)
        ->setPrecio($precio)
        ->setDescripcion($descripcion)
        ->setUsuarioId($id_usuario[0])
        ->create();

    $_SESSION['mensaje'] = "Producto Creado";
    header("Location:menu.php");

}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CDN Tailwindcss -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- CDN FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CDN SweetAlert2 -->
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js
"></script>
    <title>Añadir Vehiculo</title>
</head>

<body class="min-h-screen bg-gradient-to-br from-violet-300 via-violet-200 to-violet-100 p-6">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST"
        class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md space-y-4">

        <h2 class="text-2xl font-semibold text-center mb-4">
            <i class="fa-solid fa-car"></i> Agregar Vehículo
        </h2>

        <div>
            <label class="font-medium">Marca</label>
            <div class="flex items-center border rounded px-3">
                <i class="fa-solid fa-industry text-gray-500 mr-2"></i>
                <input type="text" name="marca" class="w-full py-2 outline-none" placeholder="Ej: Toyota" required>
                <?= Validacion::pintarErrores('err_marca'); ?>
            </div>
        </div>

        <div>
            <label class="font-medium">Modelo</label>
            <div class="flex items-center border rounded px-3">
                <i class="fa-solid fa-ruler-combined text-gray-500 mr-2"></i>
                <input type="text" name="modelo" class="w-full py-2 outline-none" placeholder="Ej: Corolla" required>
                <?= Validacion::pintarErrores('err_modelo'); ?>
            </div>
        </div>

        <div>
            <label class="font-medium">Tipo</label>

            <div class="flex flex-row items-center gap-6 ml-1 mt-1">

                <label class="flex items-center space-x-1 cursor-pointer">
                    <input type="radio" name="tipo" value="Coche" checked>
                    <span>Coche</span>
                </label>

                <label class="flex items-center space-x-1 cursor-pointer">
                    <input type="radio" name="tipo" value="Moto">
                    <span>Moto</span>
                </label>

                <label class="flex items-center space-x-1 cursor-pointer">
                    <input type="radio" name="tipo" value="Camión">
                    <span>Camión</span>
                </label>

                <label class="flex items-center space-x-1 cursor-pointer">
                    <input type="radio" name="tipo" value="Furgoneta">
                    <span>Furgoneta</span>
                </label>

                <label class="flex items-center space-x-1 cursor-pointer">
                    <input type="radio" name="tipo" value="Otro">
                    <span>Otro</span>
                </label>

            </div>

            <?= Validacion::pintarErrores('err_tipo'); ?>
        </div>


        <?= Validacion::pintarErrores('err_tipo'); ?>
        </div>


        <div>
            <label class="font-medium">Precio</label>
            <div class="flex items-center border rounded px-3">
                <i class="fa-solid fa-money-bill text-gray-500 mr-2"></i>
                <input type="number" name="precio" step="0.01" min="0" max="999999.99" class="w-full py-2 outline-none"
                    placeholder="Ej: 15000.50" required>
            </div>
            <?= Validacion::pintarErrores('err_precio'); ?>

        </div>

        <div>
            <label class="font-medium">Descripción</label>
            <div class="flex items-start border rounded px-3">
                <i class="fa-solid fa-align-left text-gray-500 mt-3 mr-2"></i>
                <textarea name="descripcion" class="w-full py-2 outline-none" rows="3"
                    placeholder="Descripción del vehículo"></textarea>
            </div>
            <?= Validacion::pintarErrores('err_descripcion'); ?>

        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fa-solid fa-floppy-disk mr-1"></i> Guardar Vehículo
        </button>
    </form>

</body>

</html>