<?php
use App\utils\Validacion;
session_start();
require __DIR__ . "/../vendor/autoload.php";

if (isset($_POST['email'])) {
    // 1.- Recogemos y saneamos los datos
    $email = Validacion::limpiarCadenas($_POST['email'] ?? '');
    $password = Validacion::limpiarCadenas($_POST['password'] ?? '');

    // 2.- Validamos
    $errores = false;

    // Comprueba que el email no esté vacío
    if (empty($email)) {
        $_SESSION['err_email'] = "*** Error, el email es obligatorio.";
        $errores = true;
    }

    if (!Validacion::longitudCadena('password', $password, 5, 15)) {
        $errores = true;
    }
    if (!Validacion::emailValido($email)) {
        $errores = true;
    }
    if (!Validacion::logValido($email, $password)) {
        $errores = true;
    }

    // 3.1 si hay errores -> redirigimos y morimos (los errores están en $_SESSION)
    if ($errores) {
        header('Location: index.php');
        die();
    }

    // 3.2 si no hay errores -> guardamos sesión y vamos al menú
    $_SESSION['email'] = $email;
    header("Location: menu.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- CDN Tailwindcss -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- CDN FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
          integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js"></script>
    <title>Login</title>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-violet-300 via-violet-200 to-violet-100 p-6">

    <form method="post" action="" class="w-full max-w-lg mx-auto bg-white/60 dark:bg-slate-900 p-10 rounded-3xl shadow-2xl backdrop-blur-md">
        <h2 class="text-3xl font-bold mb-8 text-gray-800 dark:text-gray-100 text-center">Iniciar sesión</h2>

        <div class="mb-8">
            <label for="email" class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Correo electrónico</label>
            <input
                id="email"
                name="email"
                type="email"
                required
                placeholder="tu@ejemplo.com"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                class="w-full px-5 py-3.5 text-lg rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
            />
            <?= Validacion::pintarErrores('err_email') ?>
        </div>

        <div class="mb-6">
            <label for="password" class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Contraseña</label>
            <input
                id="password"
                name="password"
                type="password"
                required
                placeholder="••••••••••"
                class="w-full px-5 py-3.5 text-lg rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
            />
            <?= Validacion::pintarErrores('err_password') ?>
        </div>

        <button type="submit"
                class="w-full py-4 text-xl rounded-xl bg-gradient-to-r from-violet-500 to-violet-700 text-white font-bold shadow-md hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-violet-300">
            Entrar
        </button>

        <!-- Errores de validación global (email/password incorrectos) -->
        <div class="mt-4">
            <?= Validacion::pintarErrores('err_validacion') ?>
        </div>
    </form>

</body>
</html>
