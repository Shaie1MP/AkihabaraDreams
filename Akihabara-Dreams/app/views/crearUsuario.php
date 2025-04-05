<?php
include '../app/includes/comprobarSesion.php';
include '../app/includes/comprobarRol.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Usuario - Akihabra Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">

    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/form.css">
</head>

<body>
<?php include '../resources/commons/navbar.php'; ?>

    <div class="container">
        <h1>Registro de Usuario</h1>
        <form action="/Akihabara-Dreams/usuarios/create" method="post" enctype="multipart/form-data">
            <h2>Información Obligatoria</h2>
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="username">Nombre de usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmar contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <label for="address">Dirección:</label>
                <textarea id="address" name="address" required></textarea>
            </div>

            <h2>Información Opcional</h2>
            <div class="form-group">
                <label for="address2">Dirección adicional 1:</label>
                <textarea id="address2" name="address2"></textarea>
            </div>
            <div class="form-group">
                <label for="address3">Dirección adicional 2:</label>
                <textarea id="address3" name="address3"></textarea>
            </div>
            <div class="form-group">
                <label for="phone">Teléfono:</label>
                <input type="tel" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="profilePic">Foto de perfil:</label>
                <input type="file" id="profilePic" name="profilePic" accept="image/*">
            </div>
            <div class="form-group">
                <label for="role">Rol</label>
                <select name="role" id="">
                    <option value="usuario">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>

            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>

</html>