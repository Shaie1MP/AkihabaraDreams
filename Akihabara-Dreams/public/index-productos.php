<?php
$productsController = new ProductsController(new ProductsRepository($connection));
switch ($action) {
    case 'actualizar':
        $productsController->updateForm($idUrl);
        break;

    case null:
        $productsController->showProducts();
        break;

    case 'eliminar':
        $productsController->deleteProduct($idUrl);
        break;

        case 'update':
            $product = new Product(
                trim(strip_tags($_POST['id'] ?? null)),
                trim(strip_tags($_POST['name'] ?? null)),
                trim(strip_tags($_POST['price'] ?? null)),
                trim(strip_tags($_POST['photo'] ?? null)),
                trim(strip_tags($_POST['description'] ?? null)),
                trim(strip_tags($_POST['stock'] ?? null)),
                trim(strip_tags($_POST['category'] ?? null)),
            );
            $productsController->updateProduct($product);
            break;
        

    case 'crear':
        $productsController->createForm();
        break;

        case 'create':
            $product = new Product(
                0,
                trim(strip_tags($_POST['name'] ?? null)),
                trim(strip_tags($_POST['price'] ?? null)),
                trim(strip_tags($_POST['photo'] ?? null)),
                trim(strip_tags($_POST['description'] ?? null)),
                trim(strip_tags($_POST['stock'] ?? null)),
                trim(strip_tags($_POST['category'] ?? null)),
            );
            $productsController->addProduct($product);
            break;
        
    case 'info':
        $productsController->searchProduct($idUrl);
        break;
}