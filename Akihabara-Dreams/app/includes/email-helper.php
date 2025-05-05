<?php
/**
 * Funciones auxiliares para el envío de correos electrónicos
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

/**
 * Función para depurar errores
 * 
 * @param mixed $data Datos a depurar
 * @param bool $die Si es true, detiene la ejecución después de mostrar los datos
 */
function debug($data, $die = false) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($die) die();
}

/**
 * Envía un correo electrónico de confirmación de compra
 * 
 * @param User $user Usuario que realizó la compra
 * @param Order $order Pedido realizado
 * @param string $currency Moneda utilizada (eur, usd, gbp)
 * @param float $conversionRate Tasa de conversión si no es euro
 * @return bool True si el correo se envió correctamente, false en caso contrario
 */
function sendOrderConfirmationEmail($user, $order, $currency = 'eur', $conversionRate = 1) {
    // Registrar intento de envío de correo en el log
    error_log("Intentando enviar correo de confirmación para el pedido #" . $order->getOrderId() . " a " . $user->getEmail());
    error_log("Número de productos en el pedido para el correo: " . count($order->getOrderDetails()));
    
    // Obtener el símbolo de la moneda
    $symbol = '€';
    if ($currency == 'usd') {
        $symbol = '$';
    } elseif ($currency == 'gbp') {
        $symbol = '£';
    }
    
    // Generar el PDF del pedido
    require_once __DIR__ . '/OrderPdfGenerator.php';
    $pdfGenerator = new OrderPdfGenerator();
    $pdfPath = $pdfGenerator->generateOrderPDF($order, $user, $currency, $conversionRate);
    
    // Construir el asunto del correo
    $subject = 'Confirmación de pedido #' . $order->getOrderId() . ' - Akihabara Dreams';
    
    // Construir el cuerpo del correo
    $message = '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">';
    $message .= '<div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px;">';
    $message .= '<div style="text-align: center; margin-bottom: 20px;">';
    $message .= '<img src="/Akihabara-Dreams/resources/images/commons/logo-AD-3.png" alt="Akihabara Dreams Logo" style="max-width: 200px;">';
    $message .= '</div>';
    
    $message .= '<h1 style="color: #ff6347; text-align: center;">¡Gracias por tu compra!</h1>';
    $message .= '<p>Hola <strong>' . htmlspecialchars($user->getName()) . '</strong>,</p>';
    $message .= '<p>Hemos recibido tu pedido correctamente. A continuación encontrarás los detalles de tu compra:</p>';
    
    $message .= '<div style="background-color: #f8f8f8; padding: 15px; border-radius: 5px; margin: 20px 0;">';
    $message .= '<h2 style="color: #333; margin-top: 0;">Detalles del Pedido #' . $order->getOrderId() . '</h2>';
    $message .= '<p><strong>Fecha del pedido:</strong> ' . $order->getOrderDate() . '</p>';
    $message .= '<p><strong>Fecha estimada de entrega:</strong> ' . $order->getArrivalDate() . '</p>';
    $message .= '<p><strong>Dirección de envío:</strong> ' . htmlspecialchars($order->getAddress()) . '</p>';
    $message .= '<p><strong>Dirección de facturación:</strong> ' . htmlspecialchars($order->getBilling()) . '</p>';
    $message .= '</div>';
    
    $message .= '<table style="width: 100%; border-collapse: collapse; margin: 20px 0;">';
    $message .= '<thead>';
    $message .= '<tr style="background-color: #f0f0f0;">';
    $message .= '<th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Producto</th>';
    $message .= '<th style="padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">Cantidad</th>';
    $message .= '<th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Precio</th>';
    $message .= '</tr>';
    $message .= '</thead>';
    $message .= '<tbody>';
    
    $total = 0;
    foreach ($order->getOrderDetails() as $detail) {
        $subtotal = $detail->getSubtotal();
        $total += $subtotal;
        
        // Convertir el precio si es necesario
        $displaySubtotal = $subtotal;
        if ($currency != 'eur') {
            $displaySubtotal = $subtotal * $conversionRate;
        }
        
        $message .= '<tr>';
        $message .= '<td style="padding: 10px; border-bottom: 1px solid #ddd;">' . htmlspecialchars($detail->getProductName()) . '</td>';
        $message .= '<td style="padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">' . $detail->getQuantity() . '</td>';
        $message .= '<td style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">' . $symbol . number_format($displaySubtotal, 2) . '</td>';
        $message .= '</tr>';
    }
    
    // Convertir el total si es necesario
    $displayTotal = $total;
    if ($currency != 'eur') {
        $displayTotal = $total * $conversionRate;
    }
    
    $message .= '</tbody>';
    $message .= '<tfoot>';
    $message .= '<tr>';
    $message .= '<td colspan="2" style="padding: 10px; text-align: right; font-weight: bold;">Total:</td>';
    $message .= '<td style="padding: 10px; text-align: right; font-weight: bold;">' . $symbol . number_format($displayTotal, 2) . '</td>';
    $message .= '</tr>';
    $message .= '</tfoot>';
    $message .= '</table>';
    
    // Añadir enlace al PDF
    $message .= '<div style="text-align: center; margin: 30px 0;">';
    $message .= '<a href="https://akihabara-dreams.com' . $pdfPath . '" style="background-color: #ff6347; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Descargar Recibo PDF</a>';
    $message .= '</div>';
    
    $message .= '<p>Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos respondiendo a este correo o a través de nuestra sección de <a href="https://akihabara-dreams.com/contacto" style="color: #ff6347; text-decoration: none;">contacto</a>.</p>';
    
    $message .= '<div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0; text-align: center; font-size: 12px; color: #777;">';
    $message .= '<p>Este es un correo automático, por favor no respondas a este mensaje.</p>';
    $message .= '<p>&copy; ' . date('Y') . ' Akihabara Dreams. Todos los derechos reservados.</p>';
    $message .= '</div>';
    
    $message .= '</div>';
    $message .= '</body></html>';
    
    // Cargar configuración de correo
    $config = include __DIR__ . '/../config/mail.php';
    
    // Guardar el correo en un archivo (útil para desarrollo)
    if ($config['development']['save_to_file']) {
        $emailFile = $config['development']['log_directory'] . 'order_' . $order->getOrderId() . '_' . time() . '.html';
        
        // Crear directorio si no existe
        if (!is_dir(dirname($emailFile))) {
            mkdir(dirname($emailFile), 0777, true);
        }
        
        // Guardar el correo en un archivo
        file_put_contents($emailFile, $message);
        error_log("Correo guardado en archivo: " . $emailFile);
    }
    
    // Intentar usar PHPMailer
    try {
        $mail = new PHPMailer(true);
        
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = $config['smtp']['host'];
        $mail->SMTPAuth = $config['smtp']['auth'];
        $mail->Username = $config['smtp']['username'];
        $mail->Password = $config['smtp']['password'];
        $mail->SMTPSecure = $config['smtp']['encryption'];
        $mail->Port = $config['smtp']['port'];
        
        // Habilitar debug SMTP (0 = desactivado, 1 = mensajes cliente, 2 = mensajes cliente y servidor)
        $mail->SMTPDebug = 0;
        
        // Configuración del correo
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->setFrom($config['from']['address'], $config['from']['name']);
        $mail->addAddress($user->getEmail(), $user->getName());
        $mail->addReplyTo($config['reply_to']['address'], $config['reply_to']['name']);
        $mail->Subject = $subject;
        $mail->Body = $message;
        
        // Adjuntar el PDF al correo
        $fullPdfPath = $_SERVER['DOCUMENT_ROOT'] . $pdfPath;
        if (file_exists($fullPdfPath)) {
            $mail->addAttachment($fullPdfPath, 'Recibo_Pedido_' . $order->getOrderId() . '.pdf');
        }
        
        // Enviar el correo
        $result = $mail->send();
        error_log("Correo enviado con PHPMailer: " . ($result ? "Éxito" : "Fallo"));
        return $result;
    } catch (Exception $e) {
        error_log("Error al enviar correo con PHPMailer: " . $e->getMessage());
        
        // Si falla PHPMailer, intentamos con mail() como último recurso
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: {$config['from']['name']} <{$config['from']['address']}>\r\n";
        $headers .= "Reply-To: {$config['reply_to']['name']} <{$config['reply_to']['address']}>\r\n";
        
        $mailResult = mail($user->getEmail(), $subject, $message, $headers);
        error_log("Resultado de mail(): " . ($mailResult ? "Éxito" : "Fallo"));
        
        return $mailResult;
    }
}

/**
 * Función para encriptar datos (importada de CookieController)
 * 
 * @param string $data Datos a encriptar
 * @return string Datos encriptados en base64
 */
function encrypt($data) {
    $key = hash('sha256', 'macarrones', true);
    $iv = openssl_random_pseudo_bytes(16);
    $encryptedData = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encryptedData);
}

/**
 * Función para desencriptar datos (complemento a la función encrypt)
 * 
 * @param string $data Datos encriptados en base64
 * @return string Datos desencriptados
 */
function decrypt($data) {
    $key = hash('sha256', 'macarrones', true);
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $encryptedData = substr($data, 16);
    return openssl_decrypt($encryptedData, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
}