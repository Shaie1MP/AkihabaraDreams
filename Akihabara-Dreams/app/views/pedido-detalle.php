<?php
// Verificar si se recibió el ID del pedido
if (!isset($_GET['id'])) {
    header('Location: /Akihabara-Dreams/pedidos/mispedidos');
    exit;
}

$orderId = $_GET['id'];

// Obtener el pedido
$order = $ordersRepository->getOrderById($orderId);

// Verificar si el pedido existe y pertenece al usuario actual
if (!$order || $order->getUserId() != unserialize($_SESSION['usuario'])->getId()) {
    header('Location: /Akihabara-Dreams/pedidos/mispedidos');
    exit;
}

// Incluir el sistema de idiomas si no está incluido
if (!function_exists('__')) {
    include_once '../app/includes/language.php';
}

// Incluir comprobarDivisa.php para tener disponibles las variables de moneda
include_once '../app/includes/comprobarDivisa.php';
?>
<!DOCTYPE html>
<html lang="<?php echo getCurrentLang(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo __('order_details_title'); ?> #<?php echo $order->getOrderId(); ?> - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/footer.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/confirmation.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include '../resources/commons/navbar.php'; ?>
    
    <div class="confirmation-container">
        <div class="confirmation-header">
            <h1><?php echo __('order_details_title'); ?> #<?php echo $order->getOrderId(); ?></h1>
        </div>
        
        <div class="order-details">
            <div class="order-info">
                <div class="info-group">
                    <h3><?php echo __('order_date'); ?></h3>
                    <p><?php echo $order->getOrderDate(); ?></p>
                </div>
                
                <div class="info-group">
                    <h3><?php echo __('order_delivery_date'); ?></h3>
                    <p><?php echo $order->getArrivalDate(); ?></p>
                </div>
                
                <div class="info-group">
                    <h3><?php echo __('order_status'); ?></h3>
                    <p class="order-status"><?php echo $order->getState(); ?></p>
                </div>
            </div>
            
            <div class="address-info">
                <div class="info-group">
                    <h3><?php echo __('order_shipping_address'); ?></h3>
                    <p><?php echo htmlspecialchars($order->getAddress()); ?></p>
                </div>
                
                <div class="info-group">
                    <h3><?php echo __('order_billing_address'); ?></h3>
                    <p><?php echo htmlspecialchars($order->getBilling()); ?></p>
                </div>
            </div>
            
            <div class="order-items">
                <h3><?php echo __('order_items'); ?></h3>
                
                <table class="items-table">
                    <thead>
                        <tr>
                            <th><?php echo __('product_name'); ?></th>
                            <th><?php echo __('product_quantity'); ?></th>
                            <th><?php echo __('product_price'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($order->getOrderDetails() as $detail): 
                            $subtotal = $detail->getSubtotal();
                            $total += $subtotal;
                            
                            // Convertir el precio si es necesario
                            $displaySubtotal = $subtotal;
                            if (isset($currency) && $currency != 'eur' && isset($convertion)) {
                                $displaySubtotal = $subtotal * $convertion;
                            }
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($detail->getProductName()); ?></td>
                                <td><?php echo $detail->getQuantity(); ?></td>
                                <td>
                                    <?php 
                                    if (isset($symbol) && $symbol === '€') {
                                        echo number_format($displaySubtotal, 2) . '€';
                                    } else if (isset($symbol)) {
                                        echo $symbol . number_format($displaySubtotal, 2);
                                    } else {
                                        echo number_format($displaySubtotal, 2) . '€';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><?php echo __('order_total'); ?></td>
                            <td>
                                <?php 
                                // Convertir el total si es necesario
                                $displayTotal = $total;
                                if (isset($currency) && $currency != 'eur' && isset($convertion)) {
                                    $displayTotal = $total * $convertion;
                                }
                                
                                if (isset($symbol) && $symbol === '€') {
                                    echo number_format($displayTotal, 2) . '€';
                                } else if (isset($symbol)) {
                                    echo $symbol . number_format($displayTotal, 2);
                                } else {
                                    echo number_format($displayTotal, 2) . '€';
                                }
                                ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <div class="confirmation-actions">
            <div class="action-buttons">
                <a href="/Akihabara-Dreams/pedidos/pdf?id=<?php echo $order->getOrderId(); ?>" class="btn-secondary">
                    <i class="fas fa-file-pdf"></i> Descargar Recibo PDF
                </a>
                <a href="/Akihabara-Dreams/pedidos/mispedidos" class="btn-secondary">
                    <i class="fas fa-list"></i> <?php echo __('view_all_orders'); ?>
                </a>
                <a href="/Akihabara-Dreams/catalogo" class="btn-primary">
                    <i class="fas fa-shopping-bag"></i> <?php echo __('continue_shopping'); ?>
                </a>
            </div>
        </div>
    </div>
    
    <?php include '../resources/commons/footer.php'; ?>
</body>
</html>
