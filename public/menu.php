<?php

use App\db\Vehiculo;
use App\utils\Codigo;

session_start();
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
    die();
    // sirve para que no se pueda entrar al archivo sin loguearse
}
require __DIR__ . "/../vendor/autoload.php";
$email = $_SESSION['email'];
$vehiculos = Vehiculo::read();

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
    <title>Document</title>
</head>

<body class="min-h-screen bg-gradient-to-br from-violet-300 via-violet-200 to-violet-100 ">
    <?= Codigo::pintarNav('Lista de Vehiculos') ?>

    <div class="p-6">
        <div class="flex flex-row-reverse mb-2">
            <a href="nuevo.php"
                class="p-2 bg-purple-700 hover:bg-purple-800 text-white rounded-xl font-bold flex items-center justify-center transitions-colors">
                <i class="fas fa-plus mr-2"></i>Nuevo
            </a>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Marca
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Modelo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tipo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Precio
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Descripcion
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Usuario
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vehiculos as $item):
                        $filaMenu = ($item->email == $email) ? "bg-purple-100" : "bg-white";
                        ?>

                        <tr class="<?= $filaMenu; ?> border-b dark:border-gray-700 border-gray-200">

                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= $item->id ?>
                            </th>
                            <td class="px-6 py-4">
                                <?= $item->marca ?>

                            </td>
                            <td class="px-6 py-4">
                                <?= $item->modelo ?>

                            </td>
                            <td class="px-6 py-4">
                                <?= $item->tipo ?>

                            </td>
                            <td class="px-6 py-4">
                                <?= $item->precio ?>

                            </td>
                            <td class="px-6 py-4">
                                <?= $item->descripcion ?>

                            </td>
                            <td class="px-6 py-4">
                                <?= $item->email ?>

                            </td>
                            <td class="px-6 py-4">
                                <form action="delete.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $item->id ?>">
                                    <a href="update.php?id=<?= $item->id ?>">
                                        <i class="fas fa-edit text-green-500 hover:text-lg mt-2"></i>
                                    </a>
                                    <button type="submit">
                                        <i class="fas fa-trash text-red-500 hover:text-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
        if(isset($_SESSION['mensaje'])){
            echo <<< TXT
            <script>
                Swal.fire({
                icon: "success",
                title: "{$_SESSION['mensaje']}",
                showConfirmButton: false,
                timer: 1500
                });
            </script>
            TXT;
            unset($_SESSION['mensaje']);
        }
    ?>

</body>

</html>