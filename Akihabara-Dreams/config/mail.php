<?php
/**
 * Configuración de correo electrónico
 */
return [
    // Configuración del servidor SMTP
    'smtp' => [
        'host' => 'smtp.gmail.com',           // Servidor SMTP 
        'port' => 587,                         // Puerto TCP para conectarse
        'encryption' => 'tls',                 // Tipo de encriptación: 'tls' o 'ssl'
        'auth' => true,                        // Habilitar autenticación SMTP
        'username' => 'akihabaradreams1@gmail.com',   // SMTP username
        'password' => 'dxcm gylb fssa gofd', // SMTP password 
    ],
    
    // Configuración del remitente
    'from' => [
        'address' => 'akihabaradreams1@gmail.com',
        'name' => 'Akihabara Dreams',
    ],
    
    // Configuración de respuesta
    'reply_to' => [
        'address' => 'akihabaradreams1@gmail.com',
        'name' => 'Soporte Akihabara Dreams',
    ],
    
    // Configuración de desarrollo
    'development' => [
        'save_to_file' => true,                // Guardar correos en archivos durante desarrollo
        'log_directory' => __DIR__ . '/../../logs/emails/', // Directorio para guardar los correos
    ],
];