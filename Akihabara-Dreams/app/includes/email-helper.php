<?php
/**
 * Funciones auxiliares para el envío de correos electrónicos
 */

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
    $message .= '<td style="padding: 10px; text-align: right; font-weight: bold;">' . number_format($displayTotal, 2) . $symbol .'</td>';
    $message .= '</tr>';
    $message .= '</tfoot>';
    $message .= '</table>';
    
    $message .= '<p>Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos respondiendo a este correo o a través de nuestra sección de <a href="https://akihabara-dreams.com/contacto" style="color: #ff6347; text-decoration: none;">contacto</a>.</p>';
    
    $message .= '<div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0; text-align: center; font-size: 12px; color: #777;">';
    $message .= '<p>Este es un correo automático, por favor no respondas a este mensaje.</p>';
    $message .= '<p>&copy; ' . date('Y') . ' Akihabara Dreams. Todos los derechos reservados.</p>';
    $message .= '</div>';
    
    $message .= '</div>';
    $message .= '</body></html>';
    
    // Cabeceras para enviar correo HTML
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Akihabara Dreams <noreply@akihabara-dreams.com>\r\n";
    $headers .= "Reply-To: soporte@akihabara-dreams.com\r\n"; // Corregido: faltaba el cierre de comillas
    
    // Intentar usar PHPMailer si está disponible
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->setFrom('noreply@akihabara-dreams.com', 'Akihabara Dreams');
            $mail->addAddress($user->getEmail(), $user->getName());
            $mail->Subject = $subject;
            $mail->Body = $message;
            
            $result = $mail->send();
            error_log("Correo enviado con PHPMailer: " . ($result ? "Éxito" : "Fallo"));
            return $result;
        } catch (Exception $e) {
            error_log("Error al enviar correo con PHPMailer: " . $e->getMessage());
            // Si falla PHPMailer, intentamos con mail()
        }
    }
    
    // Alternativa: Guardar el correo en un archivo (útil para desarrollo)
    $emailFile = __DIR__ . '/../../logs/emails/order_' . $order->getOrderId() . '_' . time() . '.html';
    
    // Crear directorio si no existe
    if (!is_dir(dirname($emailFile))) {
        mkdir(dirname($emailFile), 0777, true);
    }
    
    // Guardar el correo en un archivo
    file_put_contents($emailFile, $message);
    error_log("Correo guardado en archivo: " . $emailFile);
    
    // Intentar enviar con mail() como último recurso
    $mailResult = mail($user->getEmail(), $subject, $message, $headers);
    error_log("Resultado de mail(): " . ($mailResult ? "Éxito" : "Fallo"));
    
    return $mailResult;
}

/**
 * Genera un recibo en formato PDF para un pedido
 * 
 * @param Order $order Pedido para el que se generará el recibo
 * @param User $user Usuario que realizó la compra
 * @param string $currency Moneda utilizada (eur, usd, gbp)
 * @param float $conversionRate Tasa de conversión si no es euro
 * @return string Ruta al archivo PDF generado
 */
function generateOrderPDF($order, $user, $currency = 'eur', $conversionRate = 1) {
    // Esta función requiere una biblioteca como FPDF o TCPDF
    // Aquí se implementaría la generación del PDF
    
    // Ejemplo de implementación básica (pseudocódigo)
    /*
    require_once('tcpdf/tcpdf.php');
    
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator('Akihabara Dreams');
    $pdf->SetAuthor('Akihabara Dreams');
    $pdf->SetTitle('Pedido #' . $order->getOrderId());
    $pdf->SetSubject('Recibo de compra');
    
    $pdf->AddPage();
    
    // Añadir logo
    $pdf->Image('path/to/logo.png', 10, 10, 50);
    
    // Añadir información del pedido
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Recibo de Compra - Pedido #' . $order->getOrderId(), 0, 1, 'C');
    
    // ... Resto de la implementación ...
    
    $pdfPath = 'receipts/order_' . $order->getOrderId() . '.pdf';
    $pdf->Output($pdfPath, 'F');
    
    return $pdfPath;
    */
    
    // Por ahora, devolvemos una ruta ficticia
    return 'receipts/order_' . $order->getOrderId() . '.pdf';
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
