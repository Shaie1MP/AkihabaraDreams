<?php
session_start();

// Redirigir si ya está logueado
if(isset($_SESSION['user'])){
    header('Location: myAccount.php');
    exit;
}

require_once '../config/database.php';
require_once "../repositories/usersRepository.php";
require_once '../models/user.php';

$message = '';
$success = false;

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $message = 'Por favor, completa todos los campos.';
    } else {
        try {
            // Consultar usuario por nombre de usuario
            $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($userData && password_verify($password, $userData['password'])) {
                // Crear objeto de usuario
                $user = new User(
                    $userData['id_user'],
                    $userData['name'],
                    $userData['username'],
                    $userData['password'], // No almacenar la contraseña en texto plano
                    $userData['email'],
                    $userData['phone'],
                    $userData['address'],
                    $userData['profilePic'],
                    $userData['role']
                );
                
                // Guardar en sesión
                $_SESSION['user'] = serialize($user);
                
                // Redirigir a la página de cuenta
                header('Location: myAccount.php');
                exit;
            } else {
                $message = 'Usuario o contraseña incorrectos.';
            }
        } catch (Exception $e) {
            $message = 'Error al iniciar sesión: ' . $e->getMessage();
        }
    }
}

include("../includes/header.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Akihabara Dreams</title>
    <link rel="stylesheet" href="../../resources/css/navbar.css">
    <link rel="stylesheet" href="../../resources/css/index.css">
    <link rel="stylesheet" href="../../resources/css/form.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Iniciar Sesión</h1>
        </div>
        
        <?php if (!empty($message)): ?>
            <div class="form-message error">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="username" class="required-field">Usuario</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password" class="required-field">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-actions">
                <button type="submit">Iniciar Sesión</button>
                <a href="/Akihabara-Dreams/src/index.php" class="btn btn-secondary">Cancelar</a>
            </div>
            
            <div class="form-footer" style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                <p>¿No tienes una cuenta? <a href="register.php" style="color: var(--secondary-color);">Regístrate aquí</a></p>
            </div>
        </form>
    </div>
</body>
</html>

<?php include("../includes/footer.php"); ?>