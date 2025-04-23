<?php
session_start();
include_once 'comprobarSesion.php';
include_once 'comprobarDivisa.php';
include_once '../models/Order.php';
include_once '../models/OrderDetails.php';
include_once '../repositories/OrdersRepository.php';
include_once '../controllers/OrdersController.php';
include_once 'email-helper.php';

// Verificar si se recibieron los datos necesarios
if (!isset($_POST['address']) || !isset($_POST['billing'])) {
    header('Location: /Akihabara-Dreams/pedidos/realizar');
    exit;
}

// Obtener los datos del formulario
$address = $_POST['address'];
$billing = $_POST['billing'];

// Guardar información de la tarjeta si se solicitó
if (isset($_POST['card-information'])) {
    $cardNumber = $_POST['card-number'];
    $cardExpiration = $_POST['card-expiration'];
    $cardCvc = $_POST['card-cvc'];
    
    $encryptedCard = [
        'number' => encrypt($cardNumber),
        'date' => encrypt($cardExpiration),
        'cvc' => encrypt($cardCvc)
    ];
    
    setcookie('tarjeta', serialize($encryptedCard), time() + 3600 * 24 * 30, '/', '', false, true);
}

// Obtener el carrito y el usuario
$cart = unserialize($_SESSION['carrito']);
$user = unserialize($_SESSION['usuario']);

// Crear el pedido
$order = new Order(
    0, // El ID se asignará en la base de datos
    $user->getId(),
    null, // Fecha actual (se asigna en el constructor)
    null, // Fecha de entrega estimada (se asigna en el constructor)
    $billing, // Billing parameter
    $address, // Address parameter
    'Pendiente' // State parameter
);

// Crear el controlador y repositorio
$ordersRepository = new OrdersRepository($db);
$userRepository = new UsersRepository($db);
$ordersController = new OrdersController($ordersRepository, $userRepository);

// Crear el pedido
$ordersController->create($order, $cart);
