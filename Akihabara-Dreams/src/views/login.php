<?php
require_once "../config/database.php";
require_once "../repositories/usersRepository.php";
require_once "../models/user.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["username"];
    $password = $_POST["password"];

    $repo = new UsersRepository($pdo);
    $user = $repo->searchUser($usuario);

    if ($user && password_verify($password, $user->getPassword())) {
        $_SESSION["user_id"] = $user->getId();
        echo "Inicio de sesión exitoso.";
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>

<form action="" method="POST">
    <input type="text" name="username" placeholder="Usuario" required><br><br>
    <input type="password" name="password" placeholder="Contraseña" required><br><br>
    <button type="submit">Iniciar Sesión</button>
</form>
