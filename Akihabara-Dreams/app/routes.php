<?php
// Añadir la ruta para la página de confirmación de pedido
$router->add('/orders/confirmation', function() use ($container) {
    $orderId = isset($_GET['id']) ? $_GET['id'] : 0;
    $ordersController = $container->get('OrdersController');
    $ordersController->showConfirmation($orderId);
});

// Añadir la ruta para descargar el PDF de un pedido
$router->add('/orders/pdf', function() use ($container) {
    $orderId = isset($_GET['id']) ? $_GET['id'] : 0;
    $ordersController = $container->get('OrdersController');
    $ordersController->downloadPdf($orderId);
});
