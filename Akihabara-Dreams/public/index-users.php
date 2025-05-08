<?php
$controller = new UsersController(new UsersRepository($connection));

switch ($action) {
    case null:
        $controller->showUsers();
        break;
    case 'actualizar':
        // Verificar que el ID es válido
        if (!$idUrl || !is_numeric($idUrl)) {
            throw new Exception('ID de usuario no válido');
        }
        
        // Verificar que no es el usuario actual
        if ($idUrl == $userSession->getId()) {
            throw new Exception('No puedes actualizar tu propio usuario de esta manera.');
        }
        
        // Obtener el usuario a actualizar
        $controller->updateForm($idUrl);
        break;
    case 'create':
        $controller->insertUser(new User(
            0,
            trim(strip_tags($_POST['name'] ?? null)),
            trim(strip_tags($_POST['username'] ?? null)),
            (filter_var($correo = trim(strip_tags($_POST['email'] ?? null)), FILTER_VALIDATE_EMAIL)) ? filter_var($correo, FILTER_SANITIZE_EMAIL) : $correo,
            trim(strip_tags($_POST['address'] ?? null)),
            trim(strip_tags($_POST['address2'] ?? null)),
            trim(strip_tags($_POST['address3'] ?? null)),
            trim(strip_tags($_POST['phone'] ?? null)),
            null,
            trim(strip_tags($_POST['password'] ?? null)),
            trim(strip_tags($_POST['role'] ?? null))
        ));
        break;
    case 'crear':
        $controller->createForm();
        break;
    case 'update':
        $controller->updateUser(new User(
            trim(strip_tags($_POST['id'] ?? null)),
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
    case 'eliminar':
        if ($idUrl == $userSession->getId()) {
            throw new Exception('No puedes eliminar tu propio usuario.');
        }
        $controller->deleteUser($idUrl);
        break;
    default:
        include $view . 'errors.php';
        break;
}