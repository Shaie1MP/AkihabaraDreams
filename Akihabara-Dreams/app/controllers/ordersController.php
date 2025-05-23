<?php

class OrdersController
{
    private OrdersRepository $ordersRepository;
    private $userRepository;

    public function __construct($ordersRepository, $userRepository = null)
    {
        $this->ordersRepository = $ordersRepository;
        $this->userRepository = $userRepository;
    }

    public function orders()
    {
        $orders = $this->ordersRepository->showOrders();
        include '../app/views/orders.php';
    }

    public function myOrders($id)
    {
        $orders = $this->ordersRepository->myOrders($id);
        include '../app/views/myOrders.php';
    }

    public function newOrder()
    {
        include '../app/views/finalizePurchase.php';
    }

    public function create(Order $order, Cart $cart)
    {
        $errors = [];

        if (!$order->getAddress()) {
            $errors[] = 'La dirección no puede ser nula';
        }

        if (!$order->getBilling()) {
            $errors[] = 'La dirección de facturación no puede ser nula';
        }

        if (empty($errors)) {
            try {
                // Verificar si el carrito tiene productos
                if (count($cart->getCart()) === 0) {
                    $errors[] = 'El carrito está vacío';
                    include '../app/views/errors.php';
                    return;
                }

                // Crear el pedido en la base de datos
                $orderId = $this->ordersRepository->realizeOrder($order, $cart);

                // Actualizar el ID del pedido si es necesario
                if ($orderId) {
                    $order->setOrderId($orderId);
                } else {
                    throw new Exception("No se pudo crear el pedido");
                }

                // Vaciar el carrito
                $_SESSION['carrito'] = serialize(new Cart($order->getUserId()));

                // Enviar correo de confirmación
                if (isset($_SESSION['usuario'])) {
                    $user = unserialize($_SESSION['usuario']);

                    // Obtener la moneda y tasa de conversión
                    $currency = 'eur';
                    $conversionRate = 1;

                    if (isset($_COOKIE['divisa'])) {
                        $currency = strtolower($_COOKIE['divisa']);
                        if ($currency == 'usd') {
                            $conversionRate = 1.07;
                        } elseif ($currency == 'gbp') {
                            $conversionRate = 0.83;
                        }
                    }

                    // Incluir el helper de email
                    require_once __DIR__ . '/../includes/email-helper.php';

                    // Obtener el pedido completo con sus detalles
                    $completeOrder = $this->ordersRepository->getOrderById($orderId);

                    // Enviar el correo
                    $emailResult = sendOrderConfirmationEmail($user, $completeOrder, $currency, $conversionRate);
                    error_log("Resultado del envío de correo: " . ($emailResult ? "Éxito" : "Fallo"));
                }

                // Redirigir a la página de confirmación
                header('Location: /Akihabara-Dreams/orders/confirmation?id=' . $order->getOrderId());
                exit;
            } catch (Exception $e) {
                error_log("Error al crear pedido: " . $e->getMessage());
                $errors[] = 'Error al procesar el pedido: ' . $e->getMessage();
                include '../app/views/errors.php';
            }
        } else {
            include '../app/views/errors.php';
        }
    }

    public function showConfirmation($orderId)
    {
        // Activar depuración para identificar errores
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Obtener el pedido
        $order = $this->ordersRepository->getOrderById($orderId);

        // Depuración
        error_log("Detalles del pedido #$orderId: " . print_r($order, true));
        if ($order) {
            error_log("Número de productos en el pedido: " . count($order->getOrderDetails()));
        }

        // Verificar si el pedido existe y pertenece al usuario actual
        if (!$order || $order->getUserId() != unserialize($_SESSION['usuario'])->getId()) {
            header('Location: /Akihabara-Dreams/orders/mispedidos');
            exit;
        }

        // Pasar el repositorio a la vista para que pueda usarlo si es necesario
        $ordersRepository = $this->ordersRepository;

        // Incluir comprobarDivisa.php para tener disponibles las variables de moneda
        include_once '../app/includes/checkCurrency.php';

        // Mostrar la página de confirmación
        include '../app/views/confirmation-order.php';
    }

    /**
     * Genera y descarga un PDF para un pedido específico
     * 
     * @param int $orderId ID del pedido
     */
    public function downloadPdf($orderId)
    {
        // Asegurarse de que no haya salida previa
        if (ob_get_level()) ob_end_clean();

        // Obtener el pedido
        $order = $this->ordersRepository->getOrderById($orderId);

        // Verificar si el pedido existe y pertenece al usuario actual
        if (!$order || $order->getUserId() != unserialize($_SESSION['usuario'])->getId()) {
            header('Location: /Akihabara-Dreams/orders/mispedidos');
            exit;
        }

        // Obtener el usuario
        $user = unserialize($_SESSION['usuario']);

        // Obtener la moneda y tasa de conversión
        $currency = 'eur';
        $conversionRate = 1;

        if (isset($_COOKIE['divisa'])) {
            $currency = strtolower($_COOKIE['divisa']);
            if ($currency == 'usd') {
                $conversionRate = 1.07;
            } elseif ($currency == 'gbp') {
                $conversionRate = 0.83;
            }
        }

        // Generar el PDF directamente al navegador
        require_once __DIR__ . '/../includes/OrderPdfGenerator.php';
        $pdfGenerator = new OrderPdfGenerator();

        // Usar el método que genera y envía el PDF directamente
        $pdfGenerator->generateAndDownloadOrderPDF($order, $user, $currency, $conversionRate);
        exit;
    }

    public function getAllOrders()
    {
        return $this->ordersRepository->getAllOrders();
    }
}
