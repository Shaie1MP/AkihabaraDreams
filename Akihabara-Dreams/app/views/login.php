<?php
if (isset($_SESSION['usuario'])) {
    header('Location: /Akihabara-Dreams/micuenta');
    die;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/login.css">
</head>

<body>
    <div class="container">
        <input type="checkbox" id="flip-toggle">
        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <div class="card-decoration decoration-1"></div>
                    <div class="card-decoration decoration-2"></div>
                    <h2>Iniciar Sesión</h2>
                    <form action="/Akihabara-Dreams/loginUsuario" method="post">
                        <div class="form-group">
                            <label for="login-username">Nombre de usuario</label>
                            <input type="text" id="login-username" name="login-username" required>
                        </div>
                        <div class="form-group">
                            <label for="login-password">Contraseña</label>
                            <input type="password" id="login-password" name="login-password" required>
                        </div>
                        <button type="submit">Iniciar Sesión</button>
                    </form>

                    <div class="flip-prompt">
                        <p>¿No tienes cuenta?</p>
                        <label for="flip-toggle" class="flip-button">Regístrate</label>
                    </div>
                </div>
                <div class="flip-card-back">
                    <div class="card-decoration decoration-1"></div>
                    <div class="card-decoration decoration-2"></div>
                    <h2>Registrarse</h2>
                    <form action="/Akihabara-Dreams/registrar" method="post">
                        <div class="form-group">
                            <label for="register-name">Nombre</label>
                            <input type="text" id="register-name" name="register-name" required>
                        </div>
                        <div class="form-group">
                            <label for="register-username">Nombre de usuario</label>
                            <input type="text" id="register-username" name="register-username" required>
                        </div>
                        <div class="form-group">
                            <label for="register-email">Correo electrónico</label>
                            <input type="email" id="register-email" name="register-email" placeholder="name@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="register-password">Contraseña</label>
                            <input type="password" id="register-password" name="register-password" required>
                        </div>
                        <div class="form-group">
                            <label for="register-confirm-password">Confirmar contraseña</label>
                            <input type="password" id="register-confirm-password" name="register-confirm-password" required>
                        </div>
                        <button type="submit">Registrarse</button>
                    </form>

                    <div class="flip-prompt">
                        <p>¿Ya tienes una cuenta?</p>
                        <label for="flip-toggle" class="flip-button">Inicia sesión</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>