<?php
require_once __DIR__ . '/../../vendor/autoload.php';

class OrderPdfGenerator {
   /**
    * Genera un recibo en formato PDF para un pedido
    * 
    * @param Order $order Pedido para el que se generará el recibo
    * @param User $user Usuario que realizó la compra
    * @param string $currency Moneda utilizada (eur, usd, gbp)
    * @param float $conversionRate Tasa de conversión si no es euro
    * @return string Ruta al archivo PDF generado
    */
   public function generateOrderPDF($order, $user, $currency = 'eur', $conversionRate = 1) {
       // Obtener el símbolo de la moneda
       $symbol = '€';
       if ($currency == 'usd') {
           $symbol = '$';
       } elseif ($currency == 'gbp') {
           $symbol = '£';
       }
       
       // Crear instancia de TCPDF
       $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
       
       // Configurar el documento
       $pdf->SetCreator('Akihabara Dreams');
       $pdf->SetAuthor('Akihabara Dreams');
       $pdf->SetTitle('Pedido #' . $order->getOrderId());
       $pdf->SetSubject('Recibo de compra');
       $pdf->SetKeywords('Pedido, Recibo, Akihabara Dreams');
       
       // Eliminar cabecera y pie de página por defecto
       $pdf->setPrintHeader(false);
       $pdf->setPrintFooter(false);
       
       // Establecer márgenes
       $pdf->SetMargins(15, 15, 15);
       
       // Establecer salto de página automático
       $pdf->SetAutoPageBreak(true, 15);
       
       // Añadir una página
       $pdf->AddPage();
       
       // Añadir logo
       $logoPath = __DIR__ . '/../../resources/images/commons/logo-AD-3.png';
       if (file_exists($logoPath)) {
           $pdf->Image($logoPath, 15, 15, 50);
       }
       
       // Título del documento
       $pdf->SetFont('helvetica', 'B', 20);
       $pdf->SetY(40);
       $pdf->Cell(0, 10, 'RECIBO DE COMPRA', 0, 1, 'C');
       
       // Número de pedido
       $pdf->SetFont('helvetica', 'B', 14);
       $pdf->Cell(0, 10, 'Pedido #' . $order->getOrderId(), 0, 1, 'C');
       
       // Información del cliente
       $pdf->SetY(70);
       $pdf->SetFont('helvetica', 'B', 12);
       $pdf->Cell(0, 10, 'Información del Cliente:', 0, 1, 'L');
       
       $pdf->SetFont('helvetica', '', 10);
       $pdf->Cell(40, 7, 'Nombre:', 0, 0, 'L');
       $pdf->Cell(0, 7, $user->getName(), 0, 1, 'L');
       
       $pdf->Cell(40, 7, 'Email:', 0, 0, 'L');
       $pdf->Cell(0, 7, $user->getEmail(), 0, 1, 'L');
       
       // Información del pedido
       $pdf->SetY(95);
       $pdf->SetFont('helvetica', 'B', 12);
       $pdf->Cell(0, 10, 'Detalles del Pedido:', 0, 1, 'L');
       
       $pdf->SetFont('helvetica', '', 10);
       $pdf->Cell(40, 7, 'Fecha del pedido:', 0, 0, 'L');
       $pdf->Cell(0, 7, $order->getOrderDate(), 0, 1, 'L');
       
       $pdf->Cell(40, 7, 'Fecha de entrega:', 0, 0, 'L');
       $pdf->Cell(0, 7, $order->getArrivalDate(), 0, 1, 'L');
       
       $pdf->Cell(40, 7, 'Estado:', 0, 0, 'L');
       $pdf->Cell(0, 7, $order->getState(), 0, 1, 'L');
       
       // Dirección de envío
       $pdf->SetY(125);
       $pdf->SetFont('helvetica', 'B', 12);
       $pdf->Cell(90, 10, 'Dirección de Envío:', 0, 0, 'L');
       $pdf->Cell(90, 10, 'Dirección de Facturación:', 0, 1, 'L');
       
       $pdf->SetFont('helvetica', '', 10);
       
       // Dividir las direcciones en líneas para mostrarlas mejor
       $shippingAddress = explode("\n", wordwrap($order->getAddress(), 40, "\n"));
       $billingAddress = explode("\n", wordwrap($order->getBilling(), 40, "\n"));
       
       $maxLines = max(count($shippingAddress), count($billingAddress));
       
       for ($i = 0; $i < $maxLines; $i++) {
           $shipping = isset($shippingAddress[$i]) ? $shippingAddress[$i] : '';
           $billing = isset($billingAddress[$i]) ? $billingAddress[$i] : '';
           
           $pdf->Cell(90, 7, $shipping, 0, 0, 'L');
           $pdf->Cell(90, 7, $billing, 0, 1, 'L');
       }
       
       // Tabla de productos
       $pdf->SetY(160);
       $pdf->SetFont('helvetica', 'B', 12);
       $pdf->Cell(0, 10, 'Productos:', 0, 1, 'L');
       
       // Cabecera de la tabla
       $pdf->SetFillColor(240, 240, 240);
       $pdf->SetFont('helvetica', 'B', 10);
       $pdf->Cell(90, 8, 'Producto', 1, 0, 'L', true);
       $pdf->Cell(30, 8, 'Cantidad', 1, 0, 'C', true);
       $pdf->Cell(30, 8, 'Precio', 1, 0, 'R', true);
       $pdf->Cell(30, 8, 'Subtotal', 1, 1, 'R', true);
       
       // Contenido de la tabla
       $pdf->SetFont('helvetica', '', 10);
       $total = 0;
       
       foreach ($order->getOrderDetails() as $detail) {
           $productName = $detail->getProductName();
           $quantity = $detail->getQuantity();
           $subtotal = $detail->getSubtotal();
           $price = $subtotal / $quantity;
           $total += $subtotal;
           
           // Convertir precios si es necesario
           if ($currency != 'eur') {
               $price *= $conversionRate;
               $subtotal *= $conversionRate;
           }
           
           // Truncar nombre del producto si es muy largo
           if (strlen($productName) > 45) {
               $productName = substr($productName, 0, 42) . '...';
           }
           
           $pdf->Cell(90, 7, $productName, 1, 0, 'L');
           $pdf->Cell(30, 7, $quantity, 1, 0, 'C');
           $pdf->Cell(30, 7, $symbol . number_format($price, 2), 1, 0, 'R');
           $pdf->Cell(30, 7, $symbol . number_format($subtotal, 2), 1, 1, 'R');
       }
       
       // Total
       $displayTotal = $total;
       if ($currency != 'eur') {
           $displayTotal *= $conversionRate;
       }
       
       $pdf->SetFont('helvetica', 'B', 10);
       $pdf->Cell(150, 8, 'Total', 1, 0, 'R', true);
       $pdf->Cell(30, 8, $symbol . number_format($displayTotal, 2), 1, 1, 'R', true);
       
       // Pie de página
       $pdf->SetY(-30);
       $pdf->SetFont('helvetica', 'I', 8);
       $pdf->Cell(0, 10, 'Gracias por tu compra en Akihabara Dreams.', 0, 1, 'C');
       $pdf->Cell(0, 10, '© ' . date('Y') . ' Akihabara Dreams. Todos los derechos reservados.', 0, 1, 'C');
       
       // Crear directorio para recibos si no existe
       $pdfDir = __DIR__ . '/../../public/receipts';
       if (!is_dir($pdfDir)) {
           mkdir($pdfDir, 0777, true);
       }
       
       // Guardar el PDF
       $pdfPath = $pdfDir . '/order_' . $order->getOrderId() . '.pdf';
       $pdf->Output($pdfPath, 'F');
       
       // Registrar la ruta para depuración
       error_log("PDF generado en: " . $pdfPath);
       
       // Devolver la ruta relativa para acceder desde la web
       return '/Akihabara-Dreams/public/receipts/order_' . $order->getOrderId() . '.pdf';
   }

   /**
    * Genera y envía directamente al navegador un recibo en formato PDF para un pedido
    * 
    * @param Order $order Pedido para el que se generará el recibo
    * @param User $user Usuario que realizó la compra
    * @param string $currency Moneda utilizada (eur, usd, gbp)
    * @param float $conversionRate Tasa de conversión si no es euro
    */
   public function generateAndDownloadOrderPDF($order, $user, $currency = 'eur', $conversionRate = 1) {
       // Obtener el símbolo de la moneda
       $symbol = '€';
       if ($currency == 'usd') {
           $symbol = '$';
       } elseif ($currency == 'gbp') {
           $symbol = '£';
       }
       
       // Crear instancia de TCPDF
       $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
       
       // Configurar el documento
       $pdf->SetCreator('Akihabara Dreams');
       $pdf->SetAuthor('Akihabara Dreams');
       $pdf->SetTitle('Pedido #' . $order->getOrderId());
       $pdf->SetSubject('Recibo de compra');
       $pdf->SetKeywords('Pedido, Recibo, Akihabara Dreams');
       
       // Eliminar cabecera y pie de página por defecto
       $pdf->setPrintHeader(false);
       $pdf->setPrintFooter(false);
       
       // Establecer márgenes
       $pdf->SetMargins(15, 15, 15);
       
       // Establecer salto de página automático
       $pdf->SetAutoPageBreak(true, 15);
       
       // Añadir una página
       $pdf->AddPage();
       
       // Añadir logo
       $logoPath = __DIR__ . '/../../resources/images/commons/logo-AD-3.png';
       if (file_exists($logoPath)) {
           $pdf->Image($logoPath, 15, 15, 50);
       }
       
       // Título del documento
       $pdf->SetFont('helvetica', 'B', 20);
       $pdf->SetY(40);
       $pdf->Cell(0, 10, 'RECIBO DE COMPRA', 0, 1, 'C');
       
       // Número de pedido
       $pdf->SetFont('helvetica', 'B', 14);
       $pdf->Cell(0, 10, 'Pedido #' . $order->getOrderId(), 0, 1, 'C');
       
       // Información del cliente
       $pdf->SetY(70);
       $pdf->SetFont('helvetica', 'B', 12);
       $pdf->Cell(0, 10, 'Información del Cliente:', 0, 1, 'L');
       
       $pdf->SetFont('helvetica', '', 10);
       $pdf->Cell(40, 7, 'Nombre:', 0, 0, 'L');
       $pdf->Cell(0, 7, $user->getName(), 0, 1, 'L');
       
       $pdf->Cell(40, 7, 'Email:', 0, 0, 'L');
       $pdf->Cell(0, 7, $user->getEmail(), 0, 1, 'L');
       
       // Información del pedido
       $pdf->SetY(95);
       $pdf->SetFont('helvetica', 'B', 12);
       $pdf->Cell(0, 10, 'Detalles del Pedido:', 0, 1, 'L');
       
       $pdf->SetFont('helvetica', '', 10);
       $pdf->Cell(40, 7, 'Fecha del pedido:', 0, 0, 'L');
       $pdf->Cell(0, 7, $order->getOrderDate(), 0, 1, 'L');
       
       $pdf->Cell(40, 7, 'Fecha de entrega:', 0, 0, 'L');
       $pdf->Cell(0, 7, $order->getArrivalDate(), 0, 1, 'L');
       
       $pdf->Cell(40, 7, 'Estado:', 0, 0, 'L');
       $pdf->Cell(0, 7, $order->getState(), 0, 1, 'L');
       
       // Dirección de envío
       $pdf->SetY(125);
       $pdf->SetFont('helvetica', 'B', 12);
       $pdf->Cell(90, 10, 'Dirección de Envío:', 0, 0, 'L');
       $pdf->Cell(90, 10, 'Dirección de Facturación:', 0, 1, 'L');
       
       $pdf->SetFont('helvetica', '', 10);
       
       // Dividir las direcciones en líneas para mostrarlas mejor
       $shippingAddress = explode("\n", wordwrap($order->getAddress(), 40, "\n"));
       $billingAddress = explode("\n", wordwrap($order->getBilling(), 40, "\n"));
       
       $maxLines = max(count($shippingAddress), count($billingAddress));
       
       for ($i = 0; $i < $maxLines; $i++) {
           $shipping = isset($shippingAddress[$i]) ? $shippingAddress[$i] : '';
           $billing = isset($billingAddress[$i]) ? $billingAddress[$i] : '';
           
           $pdf->Cell(90, 7, $shipping, 0, 0, 'L');
           $pdf->Cell(90, 7, $billing, 0, 1, 'L');
       }
       
       // Tabla de productos
       $pdf->SetY(160);
       $pdf->SetFont('helvetica', 'B', 12);
       $pdf->Cell(0, 10, 'Productos:', 0, 1, 'L');
       
       // Cabecera de la tabla
       $pdf->SetFillColor(240, 240, 240);
       $pdf->SetFont('helvetica', 'B', 10);
       $pdf->Cell(90, 8, 'Producto', 1, 0, 'L', true);
       $pdf->Cell(30, 8, 'Cantidad', 1, 0, 'C', true);
       $pdf->Cell(30, 8, 'Precio', 1, 0, 'R', true);
       $pdf->Cell(30, 8, 'Subtotal', 1, 1, 'R', true);
       
       // Contenido de la tabla
       $pdf->SetFont('helvetica', '', 10);
       $total = 0;
       
       foreach ($order->getOrderDetails() as $detail) {
           $productName = $detail->getProductName();
           $quantity = $detail->getQuantity();
           $subtotal = $detail->getSubtotal();
           $price = $subtotal / $quantity;
           $total += $subtotal;
           
           // Convertir precios si es necesario
           if ($currency != 'eur') {
               $price *= $conversionRate;
               $subtotal *= $conversionRate;
           }
           
           // Truncar nombre del producto si es muy largo
           if (strlen($productName) > 45) {
               $productName = substr($productName, 0, 42) . '...';
           }
           
           $pdf->Cell(90, 7, $productName, 1, 0, 'L');
           $pdf->Cell(30, 7, $quantity, 1, 0, 'C');
           $pdf->Cell(30, 7, $symbol . number_format($price, 2), 1, 0, 'R');
           $pdf->Cell(30, 7, $symbol . number_format($subtotal, 2), 1, 1, 'R');
       }
       
       // Total
       $displayTotal = $total;
       if ($currency != 'eur') {
           $displayTotal *= $conversionRate;
       }
       
       $pdf->SetFont('helvetica', 'B', 10);
       $pdf->Cell(150, 8, 'Total', 1, 0, 'R', true);
       $pdf->Cell(30, 8, $symbol . number_format($displayTotal, 2), 1, 1, 'R', true);
       
       // Pie de página
       $pdf->SetY(-30);
       $pdf->SetFont('helvetica', 'I', 8);
       $pdf->Cell(0, 10, 'Gracias por tu compra en Akihabara Dreams.', 0, 1, 'C');
       $pdf->Cell(0, 10, '© ' . date('Y') . ' Akihabara Dreams. Todos los derechos reservados.', 0, 1, 'C');
       
       // Enviar el PDF directamente al navegador para descarga
       $pdf->Output('Recibo_Pedido_' . $order->getOrderId() . '.pdf', 'D');
       exit;
   }
}
