<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="es">
<?php
$view = '../app/views/'; //esto es para ir llamando a las vistas, debemos cambiarlo a controller según sea necesario
try {

    // public/index.php
    define('BASE_PATH', dirname(__DIR__)); // Esto apunta a la raíz del proyecto

    include '../config/database.php'; //archivo de configuración para conectarnos a la base de datos.
    include '../config/loader.php'; //archivo donde se carga todo.

    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $uriSegments = explode('/', $uri);

    //todas las rutas deben ser /boardbyte/...
    //omitimos el $uriSegments['0'] por defecto ya que nos devolverá siempre boardbyte;
    $resource = $uriSegments[1] ?? null; //si esto es nulo es index o inicio, de resto indica a donde quiere ir; default es error404.
    $action = $uriSegments[2] ?? null; //si lo anterior es una tabla de nuestra BD, miramos la acción que quiera hacer (CRUD+A);
    $idUrl = $uriSegments[3] ?? null; //para saber el ID del elemento que queremos modificar;


    //este es el objeto usuario de la sesión, para tenerlo a mano y no estar llamando a la sesión todo el rato
    //al hacer un update hay que realizar una transacción por si acaso.
    //Si todo es correcto se crea un nuevo usuario con todos los datos (el de parámetros) y se le asigna a la sesion
    if (isset($_SESSION['usuario'])) {
        include '../app/includes/comprobarTiempoSesion.php';
        $userSession = unserialize($_SESSION['usuario']);
    }

    //esto es el carrito, por si acaso yo que sé
    if (isset($_SESSION['carrito'])) {
        $cartSession = unserialize($_SESSION['carrito']);
        // foreach ($carritoSesion->getCarrito() as $key => $value) {
        //     echo '<br>ID '.$value['id'];
        //     echo '<br>cantidad '.$value['cantidad'];
        //     $producto=$value['producto'];
        //     echo '<br> Nombre: '. $producto->getNombreProducto();
        //     echo '<br> ID: '. $producto->getIdProducto();
        //     echo '<br> PRECIO: '. $producto->getPrecio();
        //     echo '<br> FOTO: '. $producto->getFotoPortada();
        //     echo '<br><br>';
        // }   
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
            header('Location: /Akihabara-Dreams/micuenta');
            exit;

        case 'carrito':
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
                }
            }
            header('Location: /Akihabara-Dreams/catalogo');
            exit;

        case 'productos':
            include './index-productos.php';
            break;

        case 'usuarios':
            include './index-usuarios.php';
            break;

        case 'micuenta':
            include './index-micuenta.php';
            break;

        case 'pedidos':
            include './index-pedidos.php';
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
            header('Location: /Akihabara-Dreams/micuenta');
            exit;

        case 'catalogo':
            $repositorio = new OthersRepository($connection);
            $controller = new OtthersController($repositorio);
            $controller->catalog();
            break;

        case 'registrar':
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
    include $view . 'errores.php';
}
?>

</html>
<?php
ob_end_flush();
?>

