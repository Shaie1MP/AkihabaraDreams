<?php
if(!empty($orders)){
    foreach ($orders as $order) {
        $total=0;

        echo '<div class="order">';
        echo '<details>';
        echo '<summary class="order-summary">';
        echo '<h2>' . __('order') . ' #' . $order->getOrderId() . '</h2>';
        echo '<p>' . __('order_address'). ': ' . $order->getBilling() . '</p>';
        echo '<p>' . __('order_arrival_date'). ': ' . $order->getArrivalDate() . '</p>';
        echo '<p>' . __('order_status'). ': ' . $order->getState() . '</p>';
        echo '</summary>';
        echo '<div class="order-details">';
        echo '<h3>' . __('order_details') . '</h3>';
        echo '<ul>';
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
        echo '<div class="total-separator"></div>';
        echo '<div class="total">';
        if ($symbol === '€') {
            echo '<span>Total: ' . $total . '€</span>';
        } else {
            echo '<span>' . $symbol . number_format($total * $convertion, 2) . '</span>';
        }
        echo '</div>';
        echo '</div>';
        echo '</details>';
        echo '</div>';
    }
}else{
    echo '<p>' . __('order_no_orders'). '</p>';
}
