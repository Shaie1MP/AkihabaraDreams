<?php
if (isset($orders) && !empty($orders)) {
    foreach ($orders as $order) {
        // Determinar la clase de estado para el pedido
        $statusClass = '';
        switch (strtolower($order->getState())) {
            case 'pendiente':
                $statusClass = 'admin-order-status-pending';
                break;
            case 'procesando':
                $statusClass = 'admin-order-status-processing';
                break;
            case 'completado':
                $statusClass = 'admin-order-status-completed';
                break;
            case 'cancelado':
                $statusClass = 'admin-order-status-cancelled';
                break;
            default:
                $statusClass = 'admin-order-status-pending';
        }
        
        echo '<div class="admin-order-card">';
        echo '<div class="admin-order-header" onclick="this.parentElement.querySelector(\'.admin-order-content\').classList.toggle(\'active\')">';
        echo '<h3>Pedido #' . $order->getOrderId() . ' <span class="admin-order-status ' . $statusClass . '">' . $order->getState() . '</span></h3>';
        echo '<p>Dirección: ' . $order->getAddress() . '</p>';
        echo '<p>Fecha de llegada: ' . $order->getArrivalDate() . '</p>';
        echo '</div>';
        echo '<div class="admin-order-content">';
        echo '<ul class="admin-order-details">';

        $total = 0;

        foreach ($order->getOrderDetails() as $detail) {
            $total += $detail->getSubtotal();

            echo '<li>';
            echo '<span>' . $detail->getProductName() . ' x' . $detail->getQuantity() . '</span>';

            if ($symbol === '€') {
                echo '<span>' . $detail->getSubtotal() . '€</span>';
            } else {
                echo '<span>' . $symbol . number_format($detail->getSubtotal() * $convertion, 2) . '</span>';
            }
            echo '</li>';
        }
        
        echo '</ul>';
        echo '<div class="admin-order-total">';
        if ($symbol === '€') {
            echo '<span>Total:</span><span>' . $total . '€</span>';
        } else {
            echo '<span>Total:</span><span>' . $symbol . number_format($total * $convertion, 2) . '</span>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<div style="grid-column: 1 / -1; text-align: center; padding: 2rem; background-color: white; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">No hay pedidos disponibles</div>';
}
?>

<style>
    .admin-order-content {
        display: none;
    }
    .admin-order-content.active {
        display: block;
    }
</style>
