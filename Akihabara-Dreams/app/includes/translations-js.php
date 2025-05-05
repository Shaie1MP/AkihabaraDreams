<?php
// Incluir el sistema de idiomas si no está incluido
if (!function_exists('__')) {
    include_once __DIR__ . '/language.php';
}

// Cargar traducciones de categorías si estamos en inglés
$categoryMapping = [];
$currentLang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'es';
if ($currentLang !== 'es') {
    $categoryFile = __DIR__ . "/../translations/categories_{$currentLang}.php";
    if (file_exists($categoryFile)) {
        $categoryMapping = include $categoryFile;
    }
}

// Generar un objeto JavaScript con las traducciones necesarias
echo '<script>';
echo 'const translations = {';
echo '  filter_title: "' . __('filter_title') . '",';
echo '  filter_category: "' . __('filter_category') . '",';
echo '  filter_category_figures: "' . __('filter_category_figures') . '",';
echo '  filter_category_manga: "' . __('filter_category_manga') . '",';
echo '  filter_category_merch: "' . __('filter_category_merch') . '",';
echo '  filter_price: "' . __('filter_price') . '",';
echo '  filter_price_range1: "' . __('filter_price_range1') . '",';
echo '  filter_price_range2: "' . __('filter_price_range2') . '",';
echo '  filter_price_range3: "' . __('filter_price_range3') . '",';
echo '  filter_price_range4: "' . __('filter_price_range4') . '",';
echo '  filter_availability: "' . __('filter_availability') . '",';
echo '  filter_in_stock: "' . __('filter_in_stock') . '",';
echo '  filter_out_of_stock: "' . __('filter_out_of_stock') . '",';
echo '  filter_apply: "' . __('filter_apply') . '",';
echo '  filter_clear: "' . __('filter_clear') . '"';
echo '};';

// Añadir el mapeo de categorías para JavaScript
echo 'const categoryMapping = ' . json_encode($categoryMapping) . ';';

// Añadir la función para traducir categorías en JavaScript
echo 'const currentLang = "' . $currentLang . '";';
echo '</script>';
?>