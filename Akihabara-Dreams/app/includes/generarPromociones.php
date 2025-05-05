<div class="admin-table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th id="id-header">ID</th>
                <th>Código</th>
                <th>Descuento</th>
                <th>Descripción</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($promotions) && !empty($promotions)) {
                foreach ($promotions as $promotion) {
                    echo "<tr>";
                    echo "<td>" . $promotion->getId() . "</td>";
                    echo "<td>" . htmlspecialchars($promotion->getCode()) . "</td>";
                    echo "<td>" . $promotion->getDiscount() . "%</td>";
                    echo "<td>" . htmlspecialchars($promotion->getDescription()) . "</td>";
                    echo "<td>" . $promotion->getStartDate() . "</td>";
                    echo "<td>" . $promotion->getEndDate() . "</td>";
                    echo "<td>";
                    if ($promotion->isActive()) {
                        echo '<span class="admin-badge admin-badge-success">Activa</span>';
                    } else {
                        echo '<span class="admin-badge admin-badge-danger">Inactiva</span>';
                    }
                    echo "</td>";
                    echo "<td>
                            <div class='admin-table-actions'>
                                <a href='/Akihabara-Dreams/promociones/productos/" . $promotion->getId() . "' class='admin-btn admin-btn-secondary' title='Ver productos'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-package'>
                                        <path d='m7.5 4.27 9 5.15'></path>
                                        <path d='M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z'></path>
                                        <path d='m3.3 7 8.7 5 8.7-5'></path>
                                        <path d='M12 22V12'></path>
                                    </svg>
                                </a>
                                <a href='/Akihabara-Dreams/promociones/editar/" . $promotion->getId() . "' class='admin-btn admin-btn-primary' title='Editar'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='lucide lucide-pencil'>
                                        <path d='M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z'></path>
                                        <path d='m15 5 4 4'></path>
                                    </svg>
                                </a>
                                <form action='/Akihabara-Dreams/promociones/eliminar/" . $promotion->getId() . "' method='POST' style='display:inline;'>
                                    <button type='submit' class='admin-btn admin-btn-danger' title='Eliminar' onclick=\"return confirm('¿Estás seguro de que deseas eliminar esta promoción?');\">
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
                echo "<tr><td colspan='8' style='text-align: center;'>No hay promociones disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="/Akihabara-Dreams/resources/js/ordenarID.js"></script>
<script src="/Akihabara-Dreams/resources/js/reducirTexto.js"></script>