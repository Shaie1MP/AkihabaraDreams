<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="es">
<?php
$view = '../app/views/'; 
try {

    // public/index.php
    define('BASE_PATH', dirname(__DIR__)); // Esto apunta a la raíz del proyecto

    include '../config/database.php'; //archivo de configuración para conectarnos a la base de datos.
    include '../config/loader.php'; //archivo donde se carga todo.

    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $uriSegments = explode('/', $uri);

    //todas las rutas deben ser /Akihabara-Dreams/...
    //omitimos el $uriSegments['0'] por defecto ya que nos devolverá siempre Akihabara-Dreams;
    $resource = $uriSegments[1] ?? null; //si esto es nulo es index o inicio, de resto indica a donde quiere ir; default es error404.
    $action = $uriSegments[2] ?? null; //si lo anterior es una tabla de nuestra BD, miramos la acción que quiera hacer (CRUD+A);
    $idUrl = $uriSegments[3] ?? null; //para saber el ID del elemento que queremos modificar;
    $idUrl2 = $uriSegments[4] ?? null; // Para casos donde necesitamos un segundo ID (como eliminar un producto de una promoción)
    $idUrl3 = $uriSegments[5] ?? null; // Para el ID del producto cuando eliminamos de una promoción

    if (isset($_SESSION['usuario'])) {
        include '../app/includes/checkTimeSession.php';
        $userSession = unserialize($_SESSION['usuario']);
    }
    
    if (isset($_SESSION['carrito'])) {
        $cartSession = unserialize($_SESSION['carrito']);
    }

    switch ($resource) {
        case 'cookies':
            if (isset($userSession)) {
                $cookieController = new cookieController();
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    switch ($action) {
                        case 'divisa':
                            $cookieController->createCurrency($_POST['currency'] ?? null);
                            break;
                        case 'defecto':
                            $cookieController->createDefaultAddress($_POST['address']);
                            break;
                        case 'facturacion':
                            $cookieController->createBillingAddress($_POST['address']);
                            break;
                    }
                }
            }
            header('Location: /Akihabara-Dreams/myaccount');
            exit;

        case 'cart':
            if (isset($userSession)) {
                if (!isset($cartSession)) {
                    $cartSession = new Cart($userSession->getId());
                    $_SESSION['carrito'] = serialize($cartSession);
                }

                $cartController = new CartController(new CartRepository($connection), $cartSession);
                switch ($action) {
                    case 'add':
                        $cartController->addElement($idUrl);
                        break;
                    case 'eliminar':
                        $cartController->deleteElement($idUrl);
                        break;
                    case 'guardar':
                        $cartController->saveCartDatabase();
                        break;
                    case 'vaciar':
                        $cartController->emptyCart();
                        break;
                    case 'realizar':
                        $cartController->realizarPedido();
                        break;
                }
            } else {
                // Si no hay sesión, redirigir al login
                header('Location: /Akihabara-Dreams/login');
                exit;
            }
            break;
            
        case 'wishlist':
            include './index-wishlist.php';
            break;

        case 'products':
            include './index-products.php';
            break;

        case 'users':
            include './index-users.php';
            break;

        case 'myaccount':
            include './index-myaccount.php';
            break;

        case 'orders':
            include './index-orders.php';
            break;

        case 'promotions':
            include './index-promotions.php';
            break;

        case 'ofertas':
            $repositorio = new OthersRepository($connection);
            $controller = new OtthersController($repositorio);
            $controller->promotions();
            break;

        case 'login':
            $authController = new AuthUserController(new AuthRepository($connection));
            $authController->index();
            break;

        case 'logout':
            $authController = new AuthUserController(new AuthRepository($connection));
            $authController->logoutUser();
            break;

        case 'loginUsuario':
            $authController = new AuthUserController(new AuthRepository($connection));
            $id = $authController->loginUser(new AuthUser((filter_var($username = trim(strip_tags($_POST['login-username'] ?? null)), FILTER_VALIDATE_EMAIL)) ? filter_var($username, FILTER_SANITIZE_EMAIL) : $username, trim(strip_tags($_POST['login-password'] ?? null))));

            $cartController = new CartController(new CartRepository($connection), new Cart($id));
            $cartController->getCartDatabase();
            header('Location: /Akihabara-Dreams/myaccount');
            exit;

        case 'catalog':
            $repositorio = new OthersRepository($connection);
            $controller = new OtthersController($repositorio);
            $controller->catalog();
            break;

        case 'mangas':
            $repositorio = new OthersRepository($connection);
            $controller = new OtthersController($repositorio);
            $controller->mangas();
            break;

        case 'figures':
            $repositorio = new OthersRepository($connection);
            $controller = new OtthersController($repositorio);
            $controller->figures();
            break;

        case 'merchandising':
            $repositorio = new OthersRepository($connection);
            $controller = new OtthersController($repositorio);
            $controller->merchandising();
            break;

        case 'contacto':
            break;

        case 'register':
            $controller = new usersController(new UsersRepository($connection));
            $controller->register(new User(
                0,
                trim(strip_tags($_POST['register-name'] ?? null)),
                trim(strip_tags($_POST['register-username'] ?? null)),
                (filter_var($email = trim(strip_tags($_POST['register-email'] ?? null)), FILTER_VALIDATE_EMAIL)) ? filter_var($email, FILTER_SANITIZE_EMAIL) : $email,
                NULL,
                NULL,
                NULL,
                NULL,
                NULL,
                trim(strip_tags($_POST['register-password'] ?? null)),
                null
            ));

        case 'admin':
            $repositorio = new OthersRepository($connection);
            $controller = new OtthersController($repositorio);
            $controller->admin();
            break;
        default:
            include 'error404.html';
            break;

        case null:
            $repositorio = new OthersRepository($connection);
            $controller = new OtthersController($repositorio);
            $controller->index();
            break;
    }
} catch (Exception $e) {
    $errors[] = $e->getMessage();
    include $view . 'errors.php';
}
?>

</html>
<?php
ob_end_flush();
?>
