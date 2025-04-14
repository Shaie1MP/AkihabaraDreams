<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/footer.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/cart.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/search.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/pag.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/producto.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/products.css">
</head>

<body>
    <?php
    include '../resources/commons/navbar.php';

    include '../resources/commons/search.html';
    ?>

    <main id="catalog-container">
        <?php
        include '../app/includes/comprobarDivisa.php';
        include '../app/includes/generarCatalogo.php';
        ?>
    </main>
    <div id="paginacion"></div>
    
    <script src="/Akihabara-Dreams/resources/js/search.js"></script>
    <script src="/Akihabara-Dreams/resources/js/pag.js"></script>
        

<?php
if(isset($_SESSION['usuario'])){
    include '../app/includes/generarCarrito.php';
}else{
    echo '<div id="cartModal" class="cart-modal">
    <div class="cart-modal-content">
        <span class="close">×</span>
        <p>Debes iniciar sesión para usar el carrito.</p>
        </div>
        </div>';
}

include '../resources/commons/footer.php';
?>
<script src="/Akihabara-Dreams/resources/js/carrito.js"></script>
<script src="/Akihabara-Dreams/resources/js/filters.js"></script>
</body>

</html>
