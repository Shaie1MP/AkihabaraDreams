<?php
session_start();

// Verificar si hay una sesión activa
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once '../config/database.php';
require_once "../repositories/usersRepository.php";
require_once '../models/user.php';

$userSesion = unserialize($_SESSION['user']);

include("../includes/header.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta - <?php echo $userSesion->getUsername(); ?></title>
    <link rel="stylesheet" href="../../resources/css/navbar.css">
    <link rel="stylesheet" href="../../resources/css/footer.css">
    <link rel="stylesheet" href="../../resources/css/index.css">
    <link rel="stylesheet" href="../../resources/css/products.css">
    <link rel="stylesheet" href="../../resources/css/myaccount.css">
</head>
<body>
    <div class="account-container">
        <div class="account-header">
            <h1>Mi Cuenta</h1>
            <div class="account-avatar">
                <img src="../../resources/images/usuarios/<?php echo $userSesion->getProfilePic(); ?>" alt="Avatar del usuario">
            </div>
        </div>
        
        <div class="account-content">
            <div class="account-info">
                <h2>Información Personal</h2>
                <div class="info-details">
                    <div class="info-item">
                        <span class="info-label">Nombre:</span>
                        <span class="info-value"><?php echo htmlspecialchars($userSesion->getName()); ?></span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Usuario:</span>
                        <span class="info-value"><?php echo htmlspecialchars($userSesion->getUsername()); ?></span>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?php echo htmlspecialchars($userSesion->getEmail()); ?></span>
                    </div>
                    
                    <?php if ($userSesion->getPhone()): ?>
                    <div class="info-item">
                        <span class="info-label">Teléfono:</span>
                        <span class="info-value"><?php echo htmlspecialchars($userSesion->getPhone()); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="account-address">
                <h2>Dirección de Envío</h2>
                <?php if ($userSesion->getAddress()): ?>
                    <div class="address-box">
                        <p><?php echo htmlspecialchars($userSesion->getAddress()); ?></p>
                    </div>
                <?php else: ?>
                    <p class="no-data">No has añadido ninguna dirección todavía.</p>
                <?php endif; ?>
            </div>
            
            <div class="account-orders">
                <h2>Mis Pedidos Recientes</h2>
                <?php
                // Aquí tengo que añadir código para mostrar los pedidos recientes del usuario
                ?>
                <p class="no-data">No tienes pedidos recientes.</p>
                <a href="orders.php" class="view-all-button">Ver todos mis pedidos</a>
            </div>
            
            <?php if ($userSesion->getRole() === 'admin'): ?>
            <div class="admin-panel">
                <h2>Panel de Administración</h2>
                <div class="admin-actions">
                    <a href="insertProduct.php" class="admin-button">Gestionar Productos</a>
                    <a href="insertPromotion.php" class="admin-button">Gestionar Promociones</a>
                    <a href="users.php" class="admin-button">Gestionar Usuarios</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="account-actions">
            <a href="updateUser.php?id=<?php echo $userSesion->getId(); ?>" class="action-button edit">Editar Perfil</a>
            <a href="changePassword.php" class="action-button password">Cambiar Contraseña</a>
            <a href="../../src/logout.php" class="action-button logout">Cerrar Sesión</a>
            <?php if ($userSesion->getRole() !== 'admin'): ?>
            <a href="deleteAccount.php" class="action-button delete">Eliminar Cuenta</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php include("../includes/footer.php"); ?>