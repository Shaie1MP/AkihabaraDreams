<?php
echo '<div class="featured-carousel">';
echo '<div class="featured-carousel-track">';

foreach ($products as $game) {
    echo '<div class="featured-carousel-item">';
    echo '<a href="/Akihabara-Dreams/productos/info/' . $game->getId() . '">';
    echo '<div class="featured-carousel-image">';
    echo '<img src="/Akihabara-Dreams/resources/images/productos/portadas/' . $game->getPhoto() . '" alt="' . $game->getName() . '">';
    echo '</div>';
    echo '<div class="featured-carousel-title">';
    echo '<h3>' . $game->getName() . '</h3>';
    echo '</div>';
    echo '</a>';
    echo '</div>';
}

echo '</div>';
echo '<div class="featured-carousel-nav">';
echo '<button class="featured-carousel-button prev" aria-label="Previous slide">&#10094;</button>';
echo '<button class="featured-carousel-button next" aria-label="Next slide">&#10095;</button>';
echo '</div>';
echo '<div class="featured-carousel-dots"></div>';
echo '</div>';
?>

