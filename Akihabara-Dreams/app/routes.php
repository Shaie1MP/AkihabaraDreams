<?php
// Añadir la ruta para la página de confirmación de pedido
$router->add('/pedidos/confirmacion', function() use ($container) {
    $orderId = isset($_GET['id']) ? $_GET['id'] : 0;
    $ordersController = $container->get('OrdersController');
    $ordersController->showConfirmation($orderId);
});
