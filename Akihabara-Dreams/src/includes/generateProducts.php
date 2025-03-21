
<h2>Lista de Productos</h2>
<ul>
    <?php foreach ($products as $product): ?>
        <li>
            <h3><?php echo htmlspecialchars($product->getName()); ?></h3>
            <p><?php echo htmlspecialchars($product->getDescription()); ?></p>
            <p>Precio: <?php echo number_format($product->getPrice(), 2); ?> €</p>
            <img src="Akihabara-dreams/resources/images/productos/<?php echo htmlspecialchars($product->getPhoto()); ?>" alt="Imagen de <?php echo htmlspecialchars($product->getName()); ?>">
        </li>
    <?php endforeach; ?>
</ul>
