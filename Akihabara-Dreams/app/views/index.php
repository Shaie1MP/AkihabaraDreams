<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akihabara Dreams - Tu tienda online de Figuras, mangas y más</title>
    <link rel="stylesheet" href="/resources/css/normalize.css">
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
    ?>

    <section class="hero">
        <a href="/Akihabara-Dreams/catalogo" class="cta-button">Explorar juegos</a>
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
            <h2>MANGAS</h2>
            <div class="product-grid">
                <?php
                include '../app/includes/generarMangas.php';
                ?>
            </div>
        </section>

        <!-- Sección de figuras con nuevo estilo -->
        <section class="product-section">
            <h2>FIGURAS</h2>
            <div class="product-grid">
                <?php
                include '../app/includes/generarFiguras.php';
                ?>
            </div>
        </section>

        <!-- Sección de merchandising con nuevo estilo -->
        <section class="product-section">
            <h2>MERCHANDISING</h2>
            <div class="product-grid">
                <?php
                include '../app/includes/generarMerchandising.php';
                ?>
            </div>
        </section>

        <section class="about-us">
            <h2>Sobre Akihabara Dreams</h2>
            <p>BoardByte es tu destino online para juegos de mesa en España. Nos apasiona traerte los mejores juegos del
                mercado, desde clásicos atemporales hasta las últimas novedades. Nuestro equipo de expertos selecciona
                cuidadosamente cada juego para asegurar la mejor calidad y diversión para nuestros clientes.</p>
            <p>Con envíos rápidos a toda España y un servicio al cliente excepcional, en BoardByte nos esforzamos por
                hacer que tu experiencia de compra sea tan divertida como los juegos que vendemos.</p>
        </section>
    </div>

    <?php include '../resources/commons/footer.php' ?>

    <script src="/Akihabara-Dreams/resources/js/carousel.js"></script>
</body>

