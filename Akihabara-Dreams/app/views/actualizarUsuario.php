<?php
include '../app/includes/comprobarSesion.php';
include '../app/includes/comprobarRol.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">

    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/form.css">
</head>
<body>
<?php include '../resources/commons/navbar.php'; ?>

    <div class="container">
        <h1>Actualizar Usuario</h1>
        <?php
        include '../app/includes/generarFormularioActualizarUsuario.php';
        ?>
    </div>
</body>
</html>
