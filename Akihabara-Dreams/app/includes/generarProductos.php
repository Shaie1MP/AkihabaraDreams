<table>
    <thead>
        <tr>
            <th id="id-header">ID</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Inventario</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($products as $product) {
            // Preparar descripciones
            $description = $product->getDescription();

            echo "<tr>";
            echo "<td>" . $product->getId() . "</td>";
            echo "<td><img src='/Akihabara-Dreams/resources/images/productos/portadas/" . $product->getPhoto() . "' alt='Imagen del producto'></td>";
            echo "<td>" . $product->getName() . "</td>";
            echo "<td>" . $product->getDescription() . "</td>";
            echo "<td>" . $product->getCategory() . "</td>";
            echo "<td>" . $product->getStock() . "</td>";
            echo "<td>" . $product->getPrice() . "€</td>";
            echo "<td>
                    <div class='actions'>
                        <form action='/Akihabara-Dreams/productos/actualizar/" . $product->getId() . "' method='POST' style='display:inline;'>
                            <input type='hidden' name='product_id' value='" . $product->getId() . "'>
                            <button type='submit' class='btn-update'>Actualizar</button>
                        </form>
                        <form action='/Akihabara-Dreams/productos/eliminar/" . $product->getId() . "' method='POST' style='display:inline;'>
                            <input type='hidden' name='product_id' value='" . $product->getId() . "'>
                            <button type='submit' class='btn-delete'>Eliminar</button>
                        </form>
                    </div>
                  </td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<script src="/Akihabara-Dreams/resources/js/ordenarID.js"></script>
<script src="/Akihabara-Dreams/resources/js/reducirTexto.js"></script>