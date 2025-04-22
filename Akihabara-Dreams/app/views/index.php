<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akihabara Dreams - <?php echo __('home_subtitle'); ?></title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/cart.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/footer.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/index.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/product-grid.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
</head>

<body>
    <?php
    // Incluir el sistema de idiomas si no está incluido
    if (!function_exists('__')) {
        include_once '../app/includes/language.php';
    }
    
    include '../resources/commons/navbar.php';

    if(isset($_SESSION['usuario'])){
        include '../app/includes/generarCarrito.php';
    }else{
        echo '<div id="cartModal" class="cart-modal">
        <div class="cart-modal-content">
            <span class="close">×</span>
            <p>' . __('cart_login_required') . '</p>
            </div>
            </div>';
    }
    ?>

    <section class="hero">
        <div class="hero-content">
            <h1><?php echo __('home_welcome'); ?></h1>
            <p><?php echo __('home_subtitle'); ?></p>
            <a href="/Akihabara-Dreams/catalogo" class="cta-button"><?php echo __('home_explore'); ?></a>
        </div>
        <!-- <img src="../Akihabara-Dreams/resources/images/commons/team7.png" alt="header-image"> -->
    </section>
    <div class="container">
        <section class="featured-games">
            <h2><?php echo __('home_featured'); ?></h2>
            <?php
            include '../app/includes/generarJuegosDestacados.php';
            ?>
        </section>

        <!-- Sección de mangas con nuevo estilo -->
        <section class="product-section">
            <div class="section-header">
                <h2><?php echo __('home_mangas'); ?></h2>
                <a href="/Akihabara-Dreams/mangas" class="section-link-button"><?php echo __('home_view_all'); ?></a>
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
                <h2><?php echo __('home_figures'); ?></h2>
                <a href="/Akihabara-Dreams/figuras" class="section-link-button"><?php echo __('home_view_all'); ?></a>
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
                <h2><?php echo __('home_merch'); ?></h2>
                <a href="/Akihabara-Dreams/merchandising" class="section-link-button"><?php echo __('home_view_all'); ?></a>
            </div>
            <div class="product-grid">
                <?php
                include '../app/includes/generarMerchandising.php';
                ?>
            </div>
        </section>

        <section class="about-us">
            <div class="about-text">
                <h2><?php echo __('home_about_title'); ?></h2>
                <p><?php echo __('home_about_p1'); ?></p>
                <p><?php echo __('home_about_p2'); ?></p>
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
