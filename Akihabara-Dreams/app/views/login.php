<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirigir si ya hay sesión de usuario
if (isset($_SESSION['usuario'])) {
    header('Location: /Akihabara-Dreams/myaccount');
    exit;
}

// Recuperar errores y datos de sesión
$loginError = $_SESSION['login_error'] ?? '';
$registerError = $_SESSION['register_error'] ?? '';
$loginUsername = $_SESSION['login_username'] ?? '';
$registerName = $_SESSION['register_name'] ?? '';
$registerUsername = $_SESSION['register_username'] ?? '';
$registerEmail = $_SESSION['register_email'] ?? '';

// Limpiar las variables de sesión después de usarlas
unset($_SESSION['login_error'], $_SESSION['register_error'], 
      $_SESSION['login_username'], $_SESSION['register_name'], 
      $_SESSION['register_username'], $_SESSION['register_email']);

// Determinar si debemos mostrar el formulario de registro por defecto
$showRegisterForm = !empty($registerError);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/login.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/errores.css">
</head>

<body>
    <div class="container">
        <input type="checkbox" id="flip-toggle" <?php echo $showRegisterForm ? 'checked' : ''; ?>>
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <div class="card-decoration decoration-1"></div>
                    <div class="card-decoration decoration-2"></div>
                    <h2><?php echo __('login_title')?></h2>
                    
                    <form action="/Akihabara-Dreams/loginUsuario" method="post">
                        <div class="form-group">
                            <label for="login-username"><?php echo __('login_username')?></label>
                            <input type="text" id="login-username" name="login-username" value="<?php echo htmlspecialchars($loginUsername); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="login-password"><?php echo __('login_password')?></label>
                            <input type="password" id="login-password" name="login-password" required>
                        </div>
                        
                        <?php if (!empty($loginError)): ?>
                        <div class="error-message">
                            <?php echo htmlspecialchars($loginError); ?>
                        </div>
                        <?php endif; ?>
                        
                        <button type="submit"><?php echo __('login_submit')?></button>
                    </form>

                    <div class="flip-prompt">
                        <p><?php echo __('login_no_account')?></p>
                        <label for="flip-toggle" class="flip-button"><?php echo __('login_register')?></label>
                    </div>
                </div>
                <div class="flip-card-back">
                    <div class="card-decoration decoration-1"></div>
                    <div class="card-decoration decoration-2"></div>
                    <h2><?php echo __('login_check')?></h2>
                    
                    <form action="/Akihabara-Dreams/register" method="post" id="register-form">
                        <div class="form-group">
                            <label for="register-name"><?php echo __('login_name')?></label>
                            <input type="text" id="register-name" name="register-name" value="<?php echo htmlspecialchars($registerName); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="register-username"><?php echo __('login_username')?></label>
                            <input type="text" id="register-username" name="register-username" value="<?php echo htmlspecialchars($registerUsername); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="register-email"><?php echo __('login_email')?></label>
                            <input type="email" id="register-email" name="register-email" value="<?php echo htmlspecialchars($registerEmail); ?>" placeholder="name@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="register-password"><?php echo __('login_password')?></label>
                            <input type="password" id="register-password" name="register-password" required>
                        </div>
                        <div class="form-group">
                            <label for="register-confirm-password"><?php echo __('login_confirm_password')?></label>
                            <input type="password" id="register-confirm-password" name="register-confirm-password" required>
                        </div>
                        
                        <?php if (!empty($registerError)): ?>
                        <div class="error-message">
                            <?php echo htmlspecialchars($registerError); ?>
                        </div>
                        <?php endif; ?>
                        
                        <button type="submit"><?php echo __('login_check')?></button>
                    </form>

                    <div class="flip-prompt">
                        <p><?php echo __('login_account')?></p>
                        <label for="flip-toggle" class="flip-button"><?php echo __('login_submit')?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
