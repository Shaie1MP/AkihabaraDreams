<?php
require_once "../config/database.php";
require_once "../controllers/usersController.php";
require_once "../repositories/usersRepository.php";
require_once "../models/user.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["name"];
    $usuario = $_POST["username"];
    $correo = $_POST["email"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    
    $user = new User(null, $nombre, $usuario, $password, $correo, $phone, $address, 'default.jpg', 'usuario');

    $repo = new UsersRepository($pdo);
    $controller = new UsersController($repo);
    
    try {
        $controller->insertUser($user);
        echo "Usuario registrado con éxito.";
    } catch (Exception $e) {
        echo "Error al registrar usuario: " . $e->getMessage();
    }
}
?>

<link rel="stylesheet" href="../../resources/css/form.css">
<link rel="stylesheet" href="../../resources/css/index.css">

<div class="form-container">
    <div class="form-header">
        <h1>Registrarse</h1>
    </div>
    
    <?php if (isset($message)): ?>
        <div class="form-message <?php echo $success ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group">
                <label for="name" class="required-field">Nombre</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="username" class="required-field">Usuario</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="email">Correo</label>
                <input type="email" name="email" placeholder="name@example.com" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password">
            </div>
        </div>
        
        <div class="form-group">
            <label for="phone">Teléfono</label>
            <input type="tel" id="phone" name="phone">
        </div>

        <div class="form-group">
            <label for="address">Dirección</label>
            <input type="text" id="address" name="address">
        </div>
        
        <div class="form-group">
            <label for="profilePic">Foto de perfil</label>
            <input type="file" id="profilePic" name="profilePic" accept="image/*">
        </div>
        
        <div class="form-actions">
            <button type="submit">Registrarse</button>
            <a href="/Akihabara-Dreams/src/index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

