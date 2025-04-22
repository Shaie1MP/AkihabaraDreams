<?php

// include '../app/models/';
// include '../app/controllers/';
// include '../app/repositories/';

include_once __DIR__ . '/../app/includes/language.php';

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
