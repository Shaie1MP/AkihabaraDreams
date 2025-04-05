<?php

class OrdersController {
    private OrdersRepository $ordersRepository;

    public function __construct($ordersRepository) {
        $this->ordersRepository = $ordersRepository;
    }

    public function orders() {
        $orders = $this->ordersRepository->showOrders();
        include '../app/views/pedidos.php';
    }

    public function myOrders($id) {
        $orders = $this->ordersRepository->myOrders($id);
        include '../app/views/mispedidos.php';
    }
    
    public function newOrder() {
        include '../app/views/finalizarCompra.php';
    }

    public function create(Order $order, Cart $cart) {
        $errors = [];

        if (!$order->getAddress()) {
            $errors[] = 'La dirección no puede ser nula';
        }
        
        if (!$order->getBilling()) {
            $errors[] = 'La dirección de facturación no puede ser nula';
        }

        if(empty($errors)){
            $this->ordersRepository->realizeOrder($order, $cart);
            $_SESSION['carrito']=serialize(new Cart($order->getOrderId()));
            
            header('Location: /Akihabara-Dreams/pedidos/mispedidos');
            die;
        }else{
            include '../app/views/errores.php';
        }

    }


}