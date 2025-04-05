<?php

$controller = new MyAccountController(new UsersRepository($connection));
switch ($action) {
    case null:
        $controller->index();
        break;
    case 'update':
        $controller->update(new User(
            $userSession->getId(),
            trim(strip_tags($_POST['name'] ?? null)),
            trim(strip_tags($_POST['username'] ?? null)),
            (filter_var($email = trim(strip_tags($_POST['email'] ?? null)), FILTER_VALIDATE_EMAIL)) ? filter_var($email, FILTER_SANITIZE_EMAIL) : $email,
            trim(strip_tags($_POST['address'] ?? null)),
            trim(strip_tags($_POST['address2'] ?? null)),
            trim(strip_tags($_POST['address3'] ?? null)),
            trim(strip_tags($_POST['phone'] ?? null)),
            trim(strip_tags($_POST['actual_photo'] ?? null)),
            trim(strip_tags($_POST['password'] ?? null)),
            trim(strip_tags($_POST['role'] ?? null))
        ));
        
        break;
    case 'actualizar';
        $controller->updateMyData();
        break;
    case 'borrar':
        $controller->delete($userSession->getId());

}