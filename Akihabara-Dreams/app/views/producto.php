<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product->getName() ?></title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/cart.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/producto.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/footer.css">
</head>

<body>
    <?php
    include '../resources/commons/navbar.php';
    ?>

    <div class="container">
        <?php
        include '../app/includes/generarProductoUnico.php';
        ?>
    </div>

    <script src="/Akihabara-Dreams/resources/js/producto.js"></script>
</body>

</html>