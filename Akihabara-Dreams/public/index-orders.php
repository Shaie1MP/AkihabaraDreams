<?php
$controller = new OrdersController(new OrdersRepository($connection));
switch ($action) {
    case 'mispedidos':
        $controller->myOrders($userSession->getID());
        break;
    case null:
        $controller->orders();
        break;
    case 'realizar':
        $controller->newOrder();
        break;
    case 'confirmation':
        $controller->showConfirmation($_GET['id'] ?? 0);
        break;
    case 'pdf':
        // Manejar la descarga del PDF directamente
        $orderId = isset($_GET['id']) ? $_GET['id'] : 0;
        $controller->downloadPdf($orderId);
        break;
    case 'create':
        if (isset($_POST['card-information'])) {
            $cookieController = new CookieController();
            $cookieController->createCardData([
                'number' => trim(strip_tags($_POST['card-number'] ?? null)),
                'date' => trim(strip_tags($_POST['card-expiration'] ?? null)),
                'cvc' => trim(strip_tags($_POST['card-cvc'] ?? null))
            ]);
        }
        $order = new Order(
            0,
            $userSession->getId(),
            trim(strip_tags($_POST['billing'] ?? null)), 
            trim(strip_tags($_POST['address'] ?? null)), 
            'Pendiente',
            null,
            null,
        );
        $controller->create($order, $cartSession);
        break;
}
