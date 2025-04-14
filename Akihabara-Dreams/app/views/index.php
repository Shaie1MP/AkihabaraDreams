<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akihabara Dreams - Tu tienda online de Figuras, mangas y más</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/cart.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/footer.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/index.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/product-grid.css">
</head>

<body>
    <?php
    include '../resources/commons/navbar.php';

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
    ?>

    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenido a Akihabara Dreams</h1>
            <p>Tu tienda online de  mangas, figuras y merchandising</p>
            <a href="/Akihabara-Dreams/catalogo" class="cta-button">Explorar productos</a>
        </div>
        <img src="../Akihabara-Dreams/resources/images/commons/naruto.png" alt="header-image">
    </section>
    <div class="container">
        <section class="featured-games">
            <h2>Productos Destacados</h2>
            <?php
            include '../app/includes/generarJuegosDestacados.php';
            ?>
        </section>

        <!-- Sección de mangas con nuevo estilo -->
        <section class="product-section">
            <div class="section-header">
                <h2>MANGAS</h2>
                <a href="/Akihabara-Dreams/mangas" class="section-link-button">Ver todos</a>
            </div>

            <div class="product-grid">
                <?php
                include '../app/includes/generarMangas.php';
                ?>
            </div>
        </section>

        <!-- Sección de figuras con nuevo estilo -->
        <section class="product-section">
            <div class="section-header">
                <h2>FIGURAS</h2>
                <a href="/Akihabara-Dreams/figuras" class="section-link-button">Ver todos</a>
            </div>
            <div class="product-grid">
                <?php
                include '../app/includes/generarFiguras.php';
                ?>
            </div>
        </section>

        <!-- Sección de merchandising con nuevo estilo -->
        <section class="product-section">
            <div class="section-header">
                <h2>MERCHANDISING</h2>
                <a href="/Akihabara-Dreams/merchandising" class="section-link-button">Ver todos</a>
            </div>
            <div class="product-grid">
                <?php
                include '../app/includes/generarMerchandising.php';
                ?>
            </div>
        </section>

        <section class="about-us">
            <div class="about-text">
                <h2>Sobre Nosotros</h2>
                <p>Akihabara Dreams es tu tienda online de confianza para figuras, mangas y mucho más. Nos apasiona la cultura
                    japonesa y trabajamos cada día para ofrecerte una selección única de productos inspirados en el anime, el
                    manga y los videojuegos.</p>
                <p>Desde figuras coleccionables de tus personajes favoritos hasta los últimos lanzamientos de manga, en 
                    Akihabara Dreams cuidamos cada detalle para brindarte calidad, autenticidad y una experiencia de compra 
                    inolvidable. Con envíos rápidos a toda España y atención al cliente cercana y especializada, estamos aquí 
                    para ayudarte a vivir tu pasión al máximo.</p>
            </div>

            <div class="image-container">
                <img src="../Akihabara-Dreams/resources/images/commons/naruto&sasuke.png" alt="about-image">
            </div>
        </section>
    </div>

    <?php include '../resources/commons/footer.php' ?>

    <script src="/Akihabara-Dreams/resources/js/carrito.js"></script>
    <script src="/Akihabara-Dreams/resources/js/carousel.js"></script>
</body>
