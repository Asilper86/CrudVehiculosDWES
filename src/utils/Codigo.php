<?php
namespace App\utils;

class Codigo
{
    public static function pintarNav(string $titulo): void
    {
        echo <<<TXT
        <nav class="bg-purple-600 text-white px-6 py-3 flex justify-between items-center shadow-md">
            <!-- Logo o título -->
            <div class="flex items-center space-x-2">
                <i class="fas fa-user-shield text-2xl"></i>
                <span class="font-semibold text-lg tracking-wide">$titulo</span>
            </div>

            <!-- Email y Logout -->
            <div class="flex items-center space-x-3">
                <input type="text" readonly value="{$_SESSION['email']}"
                    class="bg-purple-400 text-white px-3 py-1 rounded-lg text-sm focus:outline-none cursor-default w-52 text-center" />
                <form action="cerrar.php" method="POST">
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-500 px-3 py-1 rounded-lg flex items-center space-x-1 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="font-medium text-sm">Logout</span>
                    </button>
                </form>
            </div>
        </nav>
        TXT;
    }
}
