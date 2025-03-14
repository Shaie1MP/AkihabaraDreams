<?php
class OrdersController {
    private OrdersRepository $ordersRepository;

    public function __construct(OrdersRepository $ordersRepository) {
        $this->ordersRepository = $ordersRepository;
    }

    public function getOrders() {
        $orders = $this->ordersRepository->getOrders();
        //include '../src/views/orders.php';
    }

    public function myOrders($id) {
        $orders = $this->ordersRepository->myOrders($id);
        //include '../src/views/myOrders.php';
    }

    public function newOrder() {
        //include '../src/views/endPurchase.php';
    }

    public function createOrder(Order $order, Cart $cart) {
        $errors = [];

        if (!$order->getAddress()) {
            $errors[] = 'La dirección no puede ser nula';
        }

        if (!$order->getBilling()) {
            $errors[] = 'La dirección de facturación no puede ser nula';
        }

        if (empty($errors)) {
            $this->ordersRepository->realizeOrder($order, $cart);
            $_SESSION['cart'] = serialize(new Cart($order->getOrderId()));

            //header('Location: /akihabaraDreams/orders/myOrders');
            die;
        } else {
            //include '../src/views/errors.php';
        }
    }
}