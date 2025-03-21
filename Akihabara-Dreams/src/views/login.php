<?php
require_once "../config/database.php";
require_once "../repositories/usersRepository.php";
require_once "../models/user.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $repo = new UsersRepository($pdo);
    
    // Primero, buscamos el usuario por su nombre
    $user = $repo->searchUser($username); 

    if ($user) {
        $id = $user->getId(); // Ahora sí tenemos un objeto User válido
        $user = $repo->searchUser($id); // Buscar por ID
        
        if ($user && password_verify($password, $user->getPassword())) {
            $_SESSION["user_id"] = $user->getId();
            header("Location: /Akihabara-Dreams/src/index.php");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}

?>

<link rel="stylesheet" href="../../resources/css/form.css">
<link rel="stylesheet" href="../../resources/css/index.css">

<div class="form-container">
    <div class="form-header">
        <h1>Iniciar Sesión</h1>
    </div>
    
    <?php if (isset($message)): ?>
        <div class="form-message <?php echo $success ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-row">           
            <div class="form-group">
                <label for="username" class="required-field">Usuario</label>
                <input type="text" id="username" name="username" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password">
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit">Iniciar Sesión</button>
            <a href="/Akihabara-Dreams/src/index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

