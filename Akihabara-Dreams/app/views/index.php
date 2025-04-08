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
                <h2>Sobre Akihabara Dreams</h2>
                <p>BoardByte es tu destino online para juegos de mesa en España. Nos apasiona traerte los mejores juegos del
                    mercado, desde clásicos atemporales hasta las últimas novedades. Nuestro equipo de expertos selecciona
                    cuidadosamente cada juego para asegurar la mejor calidad y diversión para nuestros clientes.</p>
                <p>Con envíos rápidos a toda España y un servicio al cliente excepcional, en BoardByte nos esforzamos por
                    hacer que tu experiencia de compra sea tan divertida como los juegos que vendemos.</p>
            </div>

            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7039.2115079763025!2d-15.442067225448719!3d28.097566208174452!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xc4095b954df2b5f%3A0x2bec717ab8988008!2sIES%20Ana%20Luisa%20Ben%C3%ADtez!5e0!3m2!1ses!2ses!4v1726578862687!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>
    </div>

    <?php include '../resources/commons/footer.php' ?>

    <script src="/Akihabara-Dreams/resources/js/carousel.js"></script>
</body>
