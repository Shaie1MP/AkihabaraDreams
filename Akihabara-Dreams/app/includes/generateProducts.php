<div class="admin-table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th id="id-header">ID</th>
                <th><?php echo __('admin_product_photo')?></th>
                <th><?php echo __('admin_product_name')?></th>
                <th><?php echo __('admin_product_description')?></th>
                <th><?php echo __('admin_product_category')?></th>
                <th><?php echo __('admin_product_stock')?></th>
                <th><?php echo __('admin_product_price')?></th>
                <th><?php echo __('admin_product_actions')?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($products) && !empty($products)) {
                foreach ($products as $product) {
                    echo "<tr>";
                    echo "<td>" . $product->getId() . "</td>";
                    echo "<td><img src='/Akihabara-Dreams/resources/images/productos/portadas/" . $product->getPhoto() . "' alt='Imagen del producto'></td>";
                    echo "<td>" . $product->getName() . "</td>";
                    echo "<td>" . $product->getDescription() . "</td>";
                    echo "<td>" . $product->getCategory() . "</td>";
                    echo "<td>" . $product->getStock() . "</td>";
                    echo "<td>" . $product->getPrice() . "€</td>";
                    echo "<td>
                            <div class='admin-table-actions'>
                                <a href='/Akihabara-Dreams/products/actualizar/" . $product->getId() . "' class='admin-btn admin-btn-primary'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-pencil'>
                                        <path d='M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z'></path>
                                        <path d='m15 5 4 4'></path>
                                    </svg>
                                </a>
                                <form action='/Akihabara-Dreams/products/eliminar/" . $product->getId() . "' method='POST' style='display:inline;'>
                                    <input type='hidden' name='product_id' value='" . $product->getId() . "'>
                                    <button type='submit' class='admin-btn admin-btn-danger'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-trash-2'>
                                            <path d='M3 6h18'></path>
                                            <path d='M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6'></path>
                                            <path d='M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2'></path>
                                            <line x1='10' x2='10' y1='11' y2='17'></line>
                                            <line x1='14' x2='14' y1='11' y2='17'></line>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' style='text-align: center;'>No hay productos disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="/Akihabara-Dreams/resources/js/orderID.js"></script>