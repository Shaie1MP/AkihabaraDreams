<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akihabara Dreams - <?php echo __('home_subtitle'); ?></title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/carrito.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/footer.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/index.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/product-grid.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/promociones.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/wishlist.css">
</head>

<body>
    <?php
    // Incluir el sistema de idiomas si no está incluido
    if (!function_exists('__')) {
        include_once '../app/includes/language.php';
    }
    
    include '../resources/commons/navbar.php';

    if(isset($_SESSION['usuario'])){
        include '../app/includes/generateCart.php';
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
            <a href="/Akihabara-Dreams/catalog" class="cta-button"><?php echo __('home_explore'); ?></a>
        </div>
    </section>
    <div class="container">
        <section class="featured-games">
            <h2><?php echo __('home_featured'); ?></h2>
            <?php
            include '../app/includes/generateFeaturedProducts.php';
            ?>
        </section>

        <!-- Sección de promociones -->
        <section class="product-section promociones-section">
            <div class="section-header">
                <h2><?php echo __('home_discounts')?></h2>
                <a href="/Akihabara-Dreams/ofertas" class="section-link-button"><?php echo __('home_view_all'); ?></a>
            </div>
            <div class="product-grid">
                <?php
                include '../app/includes/generatePromotionsIndex.php';
                ?>
            </div>
        </section>

        <!-- Sección de mangas -->
        <section class="product-section">
            <div class="section-header">
                <h2><?php echo __('home_mangas'); ?></h2>
                <a href="/Akihabara-Dreams/mangas" class="section-link-button"><?php echo __('home_view_all'); ?></a>
            </div>

            <div class="product-grid">
                <?php
                include '../app/includes/generateMangas.php';
                ?>
            </div>
        </section>

        <!-- Sección de figuras -->
        <section class="product-section">
            <div class="section-header">
                <h2><?php echo __('home_figures'); ?></h2>
                <a href="/Akihabara-Dreams/figures" class="section-link-button"><?php echo __('home_view_all'); ?></a>
            </div>
            <div class="product-grid">
                <?php
                include '../app/includes/generateFigures.php';
                ?>
            </div>
        </section>

        <!-- Sección de merchandising -->
        <section class="product-section">
            <div class="section-header">
                <h2><?php echo __('home_merch'); ?></h2>
                <a href="/Akihabara-Dreams/merchandising" class="section-link-button"><?php echo __('home_view_all'); ?></a>
            </div>
            <div class="product-grid">
                <?php
                include '../app/includes/generateMerchandising.php';
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

    <script src="/Akihabara-Dreams/resources/js/cart.js"></script>
    <script src="/Akihabara-Dreams/resources/js/carousel.js"></script>
</body>