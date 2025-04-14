<?php
include '../app/includes/comprobarSesion.php';
include '../app/includes/comprobarDivisa.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/information.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/footer.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/pedidos.css">
</head>

<body>
<?php
include '../resources/commons/navbar.php';
?>

    <div class="container">
        <h1>Mis Pedidos</h1>
        <div id="orders-container">
            <?php
            include '../app/includes/generarMisPedidos.php';
            ?>
        </div>
    </div>
</body>

</html>