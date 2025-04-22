<?php
/**
 * Sistema de gestión de idiomas
 */

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Idiomas disponibles
$available_languages = ['es', 'en'];

// Establecer idioma por defecto
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'es';
}

// Cambiar idioma si se solicita
if (isset($_GET['lang']) && in_array($_GET['lang'], $available_languages)) {
    $_SESSION['lang'] = $_GET['lang'];
    
    // Redirigir a la misma página sin el parámetro lang
    $redirect_url = strtok($_SERVER['REQUEST_URI'], '?');
    
    // Mantener otros parámetros GET excepto 'lang'
    $params = $_GET;
    unset($params['lang']);
    
    if (!empty($params)) {
        $redirect_url .= '?' . http_build_query($params);
    }
    
    header('Location: ' . $redirect_url);
    exit;
}

// Cargar archivo de traducción
$lang = $_SESSION['lang'];
$translations = [];

$lang_file = __DIR__ . "/../lang/{$lang}.php";
if (file_exists($lang_file)) {
    $translations = include $lang_file;
} else {
    // Si no existe el archivo, cargar el idioma por defecto
    $translations = include __DIR__ . "/../lang/es.php";
}

// Incluir funciones de traducción para productos y categorías
include_once __DIR__ . '/translation-helper.php';

/**
 * Función para traducir texto
 * 
 * @param string $key Clave de traducción
 * @param array $params Parámetros para reemplazar en la traducción
 * @return string Texto traducido
 */
function __($key, $params = []) {
    global $translations;
    
    if (isset($translations[$key])) {
        $text = $translations[$key];
        
        // Reemplazar parámetros si existen
        if (!empty($params)) {
            foreach ($params as $param => $value) {
                $text = str_replace(":$param", $value, $text);
            }
        }
        
        return $text;
    }
    
    // Si no existe la traducción, devolver la clave
    return $key;
}

/**
 * Función para obtener la URL con el cambio de idioma
 * 
 * @param string $lang Código de idioma
 * @return string URL con el parámetro de idioma
 */
function getLangUrl($lang) {
    $current_url = strtok($_SERVER['REQUEST_URI'], '?');
    $params = $_GET;
    $params['lang'] = $lang;
    
    return $current_url . '?' . http_build_query($params);
}

/**
 * Función para verificar si un idioma está activo
 * 
 * @param string $lang Código de idioma
 * @return bool True si el idioma está activo
 */
function isLangActive($lang) {
    return $_SESSION['lang'] === $lang;
}

/**
 * Función para obtener el idioma actual
 * 
 * @return string Código del idioma actual
 */
function getCurrentLang() {
    return $_SESSION['lang'];
}
