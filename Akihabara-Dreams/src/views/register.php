<?php
require_once "../config/database.php";
require_once "../repositories/usersRepository.php";
require_once "../models/user.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["name"];
    $usuario = $_POST["username"];
    $correo = $_POST["email"];
    $password = $_POST["password"];

    $user = new User(null, $nombre, $usuario, $password, $correo, null, null, 'default.jpg', 'usuario');

    $repo = new UsersRepository($pdo);
    $repo->registerUser($user);

    echo "Usuario registrado con éxito.";
}
?>

<form method="POST">
    <input type="text" name="name" placeholder="Nombre" required><br><br>
    <input type="text" name="username" placeholder="Usuario" required><br><br>
    <input type="email" name="email" placeholder="Correo" required><br><br>
    <input type="password" name="password" placeholder="Contraseña" required><br><br>
    <button type="submit">Registrar</button>
</form>
