<?php
require_once 'config/database.php';
require_once "repositories/usersRepository.php";
require_once 'models/user.php';
require_once "repositories/productsRepository.php";
require_once "models/product.php";
require_once "models/order.php";
require_once "models/orderDetails.php";
require_once "repositories/ordersRepository.php";

$repoUser = new UsersRepository($pdo);
$repoProduct = new ProductsRepository($pdo);
$repoOrder = new OrdersRepository($pdo);

// Prueba obtener usuarios
$users = $repoUser->showUsers();

echo "<h2>Lista de Usuarios</h2>";
?>

<?php foreach ($users as $user): ?>
    <li>
        <h3>ID: <?php echo htmlspecialchars($user->getId()); ?></h3>
        <p>Nombre: <?php echo htmlspecialchars($user->getName()); ?></p>
        <img src="../resources/images/usuarios/<?php echo htmlspecialchars($user->getProfilePic()); ?>" alt="Imagen de <?php echo htmlspecialchars($user->getName()); ?>">
    </li>
<?php endforeach; ?>



<?php
// Obtener productos
$products = $repoProduct->getProducts();

// Obtener pedidos
$orders = $repoOrder->getOrders();
?>



<link rel="stylesheet" href="../resources/css/styles.css">

<h2>Lista de Productos</h2>
<ul>
    <?php foreach ($products as $product): ?>
        <li>
            <h3><?php echo htmlspecialchars($product->getName()); ?></h3>
            <p><?php echo htmlspecialchars($product->getDescription()); ?></p>
            <p>Precio: <?php echo number_format($product->getPrice(), 2); ?> €</p>
            <img src="../resources/images/productos/<?php echo htmlspecialchars($product->getPhoto()); ?>" alt="Imagen de <?php echo htmlspecialchars($product->getName()); ?>">
        </li>
    <?php endforeach; ?>
</ul>

<h2>Lista de Pedidos</h2>
<ul>
    <?php foreach ($orders as $order): ?>
        <li>
            <p>Producto ID: <?php echo htmlspecialchars($order->getOrderId()); ?></p>
            <p>Usuario ID: <?php echo htmlspecialchars($order->getUserId()); ?> </p>
            <p>Fecha pedido: <?php echo htmlspecialchars($order->getOrderDate()); ?></p>
            <p>Fecha llegada: <?php echo htmlspecialchars($order->getArriveDate()); ?></p>
            <p>Dirección: <?php echo htmlspecialchars($order->getAddress()); ?></p>
            <p>Facturación: <?php echo htmlspecialchars($order->getBilling()); ?></p>
            <p>Estado: <?php echo htmlspecialchars($order->getState()); ?></p>
            <p><strong>Detalles pedido:</strong></p>
            <p></p>
        </li>
    <?php endforeach; ?>
</ul>

<a href="views/login.php">Login</a>
<a href="views/register.php">Register</a>

