<?php
include '../app/includes/comprobarSesion.php';
include '../app/includes/comprobarRol.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">

    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/admin.css">
</head>

<body>
    <?php
    include '../resources/commons/navbar.php';
    ?>
    <div class="container">
        <header>
            <h1>Panel de Administración</h1>
        </header>
        <section class="content">
            <h2>Bienvenido al panel de administración</h2>
            <p>Aquí podrás gestionar los productos, usuarios y pedidos. En cada sección podrás ver todos los elementos,
                crear nuevos, modificarlos o eliminarlos según sea necesario. En la sección de
                <strong>Productos</strong>, podrás administrar los productos de tu tienda, mientras que en la sección de
                <strong>Usuarios</strong> podrás gestionar la información de los usuarios. Finalmente, en la sección de
                <strong>Pedidos</strong>, podrás controlar todos los pedidos realizados, desde su consulta hasta su
                modificación o eliminación.
            </p>
        </section>
        <section class="links">
            <div class="link-item">
                <a href="/Akihabara-Dreams/productos">Productos</a>
            </div>
            <div class="link-item">
                <a href="/Akihabara-Dreams/usuarios">Usuarios</a>
            </div>
            <div class="link-item">
                <a href="/Akihabara-Dreams/pedidos">Pedidos</a>
            </div>
        </section>

    </div>

</body>

</html>