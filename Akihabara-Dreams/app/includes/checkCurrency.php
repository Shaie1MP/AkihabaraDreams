<?php
// Verificar si existe una cookie de divisa
if (isset($_COOKIE['divisa'])) {
    $currency = strtolower($_COOKIE['divisa']);
    
    // Establecer el símbolo y la tasa de conversión según la divisa
    switch ($currency) {
        case 'usd':
            $symbol = '$';
            $convertion = 1.07; // Tasa de conversión EUR a USD
            break;
        case 'gbp':
            $symbol = '£';
            $convertion = 0.83; // Tasa de conversión EUR a GBP
            break;
        default:
            $symbol = '€';
            $convertion = 1;
            $currency = 'eur';
    }
} else {
    // Valores por defecto si no hay cookie
    $symbol = '€';
    $convertion = 1;
    $currency = 'eur';
}
