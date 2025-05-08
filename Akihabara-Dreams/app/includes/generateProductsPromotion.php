<div class="admin-table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th id="id-header">ID</th>
                <th><?php echo __('admin_product_photo')?></th>
                <th><?php echo __('admin_product_name')?></th>
                <th><?php echo __('admin_product_category')?></th>
                <th><?php echo __('admin_promotion_original_price')?></th>
                <th><?php echo __('admin_promotion_discounted_price')?></th>
                <th><?php echo __('admin_promotion_actions')?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($products) && !empty($products)) {
                foreach ($products as $product) {
                    echo "<tr>";
                    echo "<td>" . $product->getId() . "</td>";
                    echo "<td><img src='/Akihabara-Dreams/resources/images/productos/portadas/" . $product->getPhoto() . "' alt='" . htmlspecialchars($product->getName()) . "' style='width: 50px; height: 50px; object-fit: cover;'></td>";
                    echo "<td>" . htmlspecialchars($product->getName()) . "</td>";
                    echo "<td>" . htmlspecialchars($product->getCategory()) . "</td>";
                    echo "<td>" . number_format($product->getPrice(), 2) . " €</td>";
                    echo "<td>" . number_format($promotion->calculateDiscountedPrice($product->getPrice()), 2) . " €</td>";
                    echo "<td>
                            <div class='admin-table-actions'>
                                <a href='/Akihabara-Dreams/products/info/" . $product->getId() . "' class='admin-btn admin-btn-secondary' title='Ver producto'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-eye'>
                                        <path d='M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z'></path>
                                        <circle cx='12' cy='12' r='3'></circle>
                                    </svg>
                                </a>
                                <a href='/Akihabara-Dreams/promotions/productos/" . $promotion->getId() . "/eliminar/" . $product->getId() . "' class='admin-btn admin-btn-danger' title='Eliminar de la promoción' onclick=\"return confirm('¿Estás seguro de que deseas eliminar este producto de la promoción?');\">
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-x'>
                                        <path d='M18 6 6 18'></path>
                                        <path d='m6 6 12 12'></path>
                                    </svg>
                                </a>
                            </div>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' style='text-align: center;'>No hay productos en esta promoción</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="/Akihabara-Dreams/resources/js/orderID.js"></script>
