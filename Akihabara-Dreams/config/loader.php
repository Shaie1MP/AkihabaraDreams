<?php

// include '../app/models/';
// include '../app/controllers/';
// include '../app/repositories/';

require_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../app/includes/language.php';

spl_autoload_register(function ($class_name) {
    // Buscar en la carpeta models
    $models_file = __DIR__ . '/../app/models/' . $class_name . '.php';
    if (file_exists($models_file)) {
        require_once $models_file;
        return;
    }
    
    // Buscar en la carpeta controllers
    $controllers_file = __DIR__ . '/../app/controllers/' . $class_name . '.php';
    if (file_exists($controllers_file)) {
        require_once $controllers_file;
        return;
    }
    
    // Buscar en la carpeta repositories
    $repositories_file = __DIR__ . '/../app/repositories/' . $class_name . '.php';
    if (file_exists($repositories_file)) {
        require_once $repositories_file;
        return;
    }
});

include '../app/models/cart.php';
include '../app/models/cartProduct.php';
include '../app/models/order.php';
include '../app/models/orderDetails.php';
include '../app/models/product.php';
include '../app/models/user.php';
include '../app/models/authUser.php';


include '../app/controllers/cookieController.php';
include '../app/controllers/cartController.php';
include '../app/controllers/ordersController.php';
include '../app/controllers/productsController.php'; 
include '../app/controllers/usersController.php'; 
include '../app/controllers/othersController.php'; 
include '../app/controllers/authUserController.php'; 
include '../app/controllers/myAccountController.php'; 


include '../app/repositories/ordersRepository.php';
include '../app/repositories/cartRepository.php';
include '../app/repositories/productsRepository.php';
include '../app/repositories/usersRepository.php';
include '../app/repositories/othersRepository.php';
include '../app/repositories/authRepository.php';
