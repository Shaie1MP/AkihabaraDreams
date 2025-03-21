<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

echo "<h2>Bienvenido al Panel</h2>";
echo "<a href='logout.php'>Cerrar sesión</a>";
?>
