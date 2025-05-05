<?php
$controller = new PromotionsController(new PromotionsRepository($connection), new ProductsRepository($connection));

switch ($action) {
    case null:
        $controller->index();
        break;
    case 'crear':
        $controller->createForm();
        break;
    case 'create':
        $controller->create();
        break;
    case 'editar':
        $controller->editForm($idUrl);
        break;
    case 'update':
        $controller->update();
        break;
    case 'eliminar':
        $controller->delete($idUrl);
        break;
    case 'productos':
        if ($idUrl === 'agregar') {
            $controller->addProduct();
        } else if ($idUrl2 === 'agregar') {
            $controller->addProductForm($idUrl);
        } else if ($idUrl2 === 'eliminar' && isset($idUrl3)) {
            $controller->removeProduct($idUrl, $idUrl3);
        } else {
            $controller->showPromotionProducts($idUrl);
        }
        break;
    case 'ofertas':
        $controller->showPromotedProducts();
        break;
    default:
        include $view . 'errores.php';
        break;
}
