<link rel="stylesheet" href="../resources/css/products.css">
<link rel="stylesheet" href="../resources/css/category-carousel.css">

<?php
// Función para obtener los primeros 5 productos de una categoría
function getProductsByCategory($products, $category, $limit = 5) {
    $categoryProducts = [];
    foreach ($products as $product) {
        if ($product->getCategory() == $category) {
            $categoryProducts[] = $product;
            if (count($categoryProducts) >= $limit) {
                break;
            }
        }
    }
    return $categoryProducts;
}

// Función para contar el total de productos por categoría
function countProductsByCategory($products, $category) {
    $count = 0;
    foreach ($products as $product) {
        if ($product->getCategory() == $category) {
            $count++;
        }
    }
    return $count;
}

// Obtener productos por categoría
$figuras = getProductsByCategory($products, 'figuras');
$mangas = getProductsByCategory($products, 'mangas');
$merchandising = getProductsByCategory($products, 'merchandising');

// Contar total de productos por categoría
$totalFiguras = countProductsByCategory($products, 'figuras');
$totalMangas = countProductsByCategory($products, 'mangas');
$totalMerchandising = countProductsByCategory($products, 'merchandising');

// Categorías a mostrar
$categories = [
    [
        'name' => 'FIGURAS',
        'products' => $figuras,
        'total' => $totalFiguras,
        'url' => '/Akihabara-Dreams/catalogo/figuras',
        'id' => 'figuras-carousel'
    ],
    [
        'name' => 'MANGAS',
        'products' => $mangas,
        'total' => $totalMangas,
        'url' => '/Akihabara-Dreams/catalogo/mangas',
        'id' => 'mangas-carousel'
    ],
    [
        'name' => 'MERCHANDISING',
        'products' => $merchandising,
        'total' => $totalMerchandising,
        'url' => '/Akihabara-Dreams/catalogo/merchandising',
        'id' => 'merchandising-carousel'
    ]
];

// Generar carruseles para cada categoría
foreach ($categories as $category) {
    if (count($category['products']) > 0) {
?>
    <section class="category-section">
        <div class="category-header">
            <h2 class="section-title"><?php echo $category['name']; ?></h2>
        </div>

        <a href="<?php echo $category['url']; ?>" class="view-all-link">Ver todos (<?php echo $category['total']; ?>)</a>

        <div class="category-carousel-container">
            <div class="category-carousel-track">
                <?php foreach ($category['products'] as $product): ?>
                    <div class="category-carousel-slide">
                        <div class="product-card">
                            <div class="product-image-container">
                                <a href="/Akihabara-Dreams/producto/<?php echo $product->getId(); ?>">
                                    <img src="/Akihabara-Dreams/resources/images/productos/portadas/<?php echo htmlspecialchars($product->getPhoto()); ?>" alt="<?php echo htmlspecialchars($product->getName()); ?>">
                                    
                                    <?php if ($product->getStock() <= 0): ?>
                                        <span class="sold-out-label">Agotado</span>
                                    <?php endif; ?>
                                </a>
                            </div>
                            
                            <h3 class="product-title"><?php echo strtoupper(htmlspecialchars($product->getName())); ?></h3>
                            <p class="product-price"><?php echo number_format($product->getPrice(), 2); ?> €</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button class="category-carousel-button prev" aria-label="Anterior">&#10094;</button>
            <button class="category-carousel-button next" aria-label="Siguiente">&#10095;</button>
        </div>
        
        <div class="view-all-mobile">
            <a href="<?php echo $category['url']; ?>" class="view-all-button">Ver todos los <?php echo strtolower($category['name']); ?></a>
        </div>
    </section>
<?php
    }
}
?>

<script src="../resources/js/category-carousel.js"></script>