<?php
session_start();

include_once 'checkSession.php';
include_once 'checkCurrency.php';
include_once '../models/Order.php';
include_once '../models/OrderDetails.php';
include_once '../repositories/OrdersRepository.php';
include_once '../controllers/OrdersController.php';
include_once 'email-helper.php';

// Verificar si se recibieron los datos necesarios
if (!isset($_POST['address']) || !isset($_POST['billing'])) {
    header('Location: /Akihabara-Dreams/orders/realizar');
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

    // Validaciones
    if (!preg_match('/^\d{16}$/', $cardNumber)) {
        throw new Exception('El número de tarjeta no es válido. Debe contener 16 dígitos.');
    }


    if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $cardExpiration)) {
        throw new Exception('La fecha de expiración no es válida. Debe estar en formato MM/AA.');
    }


    if (!preg_match('/^\d{3}$/', $cardCvc)) {
        throw new Exception('El CVC no es válido. Debe contener 3 dígitos.');
    }

    // Encriptar los datos de la tarjeta si se van a guardar
    $encryptedCard = [
        'number' => encrypt($cardNumber),
        'date' => encrypt($cardExpiration),
        'cvc' => encrypt($cardCvc)
    ];

    // Guardar la tarjeta en una cookie si el usuario lo solicita
    if (isset($_POST['card-information'])) {
        setcookie('tarjeta', serialize($encryptedCard), time() + 3600 * 24 * 30, '/', '', false, true);
    }
}

// Obtener el carrito y el usuario
$cart = unserialize($_SESSION['carrito']);
$user = unserialize($_SESSION['usuario']);

// Crear el pedido
$order = new Order(
    0, 
    $user->getId(),
    null,
    null, 
    $billing, 
    $address, 
    'Pendiente' 
);

// Crear el controlador y repositorio
$ordersRepository = new OrdersRepository($db);
$userRepository = new UsersRepository($db);
$ordersController = new OrdersController($ordersRepository, $userRepository);

// Crear el pedido
$ordersController->create($order, $cart);
