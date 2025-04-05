<div class="game-header">
    <h1 class="game-title"><?php echo $product->getName() ?></h1>
    <?php
    echo '<img src="/Akihabara-Dreams/resources/images/productos/portadas/' . $product->getPhoto() . '". alt="Portada del juego ' . $product->getName() . '" class="game-image">';
    ?>
</div>

<section class="description">
    <p>
        <?php echo $product->getDescription(); ?>
    </p>
</section>

<section class="game-images">
    <h2>Imágenes del Juego</h2>
    <div class="image-gallery">
        <?php
        foreach ($product->getAdditionalPhotos() as $item) {
            echo '<img src="/Akihabara-Dreams/resources/images/productos/adicional/' . strtolower($item) . '">';
        }
        ?>
    </div>
</section>