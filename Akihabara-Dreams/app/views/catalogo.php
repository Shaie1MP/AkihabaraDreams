<!DOCTYPE html>
<html lang="es">
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
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/promociones.css">
</head>

<body>
    <?php
    include '../resources/commons/navbar.php';

    // Mostrar banner de promociones si estamos en la página de ofertas
    if (strpos($_SERVER['REQUEST_URI'], '/ofertas') !== false) {
        echo '<div class="promociones-banner">
            <h1>Ofertas y Promociones</h1>
            <p>¡Descubre nuestros productos con descuentos especiales!</p>
        </div>';
    }

    include '../resources/commons/search.html';
    ?>

    <main id="catalog-container">
        <?php
        include '../app/includes/comprobarDivisa.php';
        include '../app/includes/generarCatalogo.php';
        ?>
    </main>
    <div id="paginacion"></div>

    <?php 
    // Mostrar información adicional de promociones si estamos en la página de ofertas
    if (strpos($_SERVER['REQUEST_URI'], '/ofertas') !== false) {
        echo '<div class="promociones-info">
            <div class="promociones-info-container">
                <div class="promociones-info-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag">
                        <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"></path>
                        <path d="M7 7h.01"></path>
                    </svg>
                    <h3>Ofertas Exclusivas</h3>
                    <p>Descuentos especiales en productos seleccionados.</p>
                </div>
                <div class="promociones-info-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar">
                        <path d="M8 2v4"></path>
                        <path d="M16 2v4"></path>
                        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                        <path d="M3 10h18"></path>
                    </svg>
                    <h3>Promociones Temporales</h3>
                    <p>Nuestras ofertas tienen tiempo limitado. ¡Aprovéchalas!</p>
                </div>
                <div class="promociones-info-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                    </svg>
                    <h3>Notificaciones</h3>
                    <p>Regístrate para recibir alertas sobre nuevas promociones.</p>
                </div>
            </div>
        </div>';
    }
    
    include '../app/includes/translations-js.php'; 
    ?>
    
    <script src="/Akihabara-Dreams/resources/js/pag.js"></script>
    <script src="/Akihabara-Dreams/resources/js/search.js"></script>
    
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
<?php if (strpos($_SERVER['REQUEST_URI'], '/ofertas') !== false): ?>
<script src="/Akihabara-Dreams/resources/js/promociones.js"></script>
<?php endif; ?>
</body>

</html>