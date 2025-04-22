<?php
/**
 * Funciones auxiliares para traducciones de productos y categorías
 */

/**
 * Traduce el nombre de un producto
 * 
 * @param int $productId ID del producto
 * @param string $defaultName Nombre por defecto (en español)
 * @return string Nombre traducido o nombre por defecto
 */
function translateProductName($productId, $defaultName) {
    $lang = getCurrentLang();
    
    // Si el idioma es español, devolver el nombre por defecto
    if ($lang === 'es') {
        return $defaultName;
    }
    
    // Cargar traducciones
    static $translations = null;
    if ($translations === null) {
        $translationFile = __DIR__ . "/../translations/products_{$lang}.php";
        if (file_exists($translationFile)) {
            $translations = include $translationFile;
        } else {
            $translations = [];
        }
    }
    
    // Devolver traducción si existe, o nombre por defecto
    return isset($translations[$productId]) ? $translations[$productId][0] : $defaultName;
}

/**
 * Traduce la descripción de un producto
 * 
 * @param int $productId ID del producto
 * @param string $defaultDescription Descripción por defecto (en español)
 * @return string Descripción traducida o descripción por defecto
 */
function translateProductDescription($productId, $defaultDescription) {
    $lang = getCurrentLang();
    
    // Si el idioma es español, devolver la descripción por defecto
    if ($lang === 'es') {
        return $defaultDescription;
    }
    
    // Cargar traducciones
    static $translations = null;
    if ($translations === null) {
        $translationFile = __DIR__ . "/../translations/products_{$lang}.php";
        if (file_exists($translationFile)) {
            $translations = include $translationFile;
        } else {
            $translations = [];
        }
    }
    
    // Devolver traducción si existe, o descripción por defecto
    return isset($translations[$productId]) ? $translations[$productId][1] : $defaultDescription;
}

/**
 * Traduce una categoría
 * 
 * @param string $category Categoría original (en español)
 * @return string Categoría traducida o categoría original
 */
function translateCategory($category) {
    $lang = getCurrentLang();
    
    // Si el idioma es español, devolver la categoría original
    if ($lang === 'es') {
        return $category;
    }
    
    // Cargar traducciones
    static $translations = null;
    if ($translations === null) {
        $translationFile = __DIR__ . "/../translations/categories_{$lang}.php";
        if (file_exists($translationFile)) {
            $translations = include $translationFile;
        } else {
            $translations = [];
        }
    }
    
    // Devolver traducción si existe, o categoría original
    return isset($translations[$category]) ? $translations[$category] : $category;
}

/**
 * Traduce un producto completo
 * 
 * @param object $product Objeto producto
 * @return object Producto con propiedades traducidas
 */
function translateProduct($product) {
    // Crear una copia del producto para no modificar el original
    $translatedProduct = clone $product;
    
    // Traducir nombre y descripción
    $translatedProduct->name = translateProductName($product->getId(), $product->getName());
    $translatedProduct->description = translateProductDescription($product->getId(), $product->getDescription());
    
    return $translatedProduct;
}
