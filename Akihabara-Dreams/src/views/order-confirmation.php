<?php
session_start();
require_once '../config/database.php';
require_once "../repositories/usersRepository.php";
require_once '../models/user.php';

include("../includes/header.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado - Akihabara Dreams</title>
    <link rel="stylesheet" href="../../resources/css/navbar.css">
    <link rel="stylesheet" href="../../resources/css/index.css">
    <link rel="stylesheet" href="../../resources/css/cart.css">
    <style>
        .confirmation-container {
            max-width: 800px;
            margin: 50px auto;
            background-color: var(--card-background);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }
        
        .confirmation-icon {
            font-size: 5rem;
            color: var(--success-color);
            margin-bottom: 20px;
        }
        
        .confirmation-title {
            font-size: 2rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }
        
        .confirmation-message {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: var(--text-light);
            line-height: 1.6;
        }
        
        .order-number {
            font-weight: bold;
            color: var(--secondary-color);
        }
        
        .confirmation-actions {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        .confirmation-button {
            display: inline-block;
            padding: 12px 25px;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .confirmation-button:hover {
            background-color: #e5533e;
            transform: translateY(-2px);
        }
        
        .confirmation-button.secondary {
            background-color: var(--primary-color);
        }
        
        .confirmation-button.secondary:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <div class="confirmation-icon">✓</div>
        <h1 class="confirmation-title">¡Pedido Confirmado!</h1>
        <p class="confirmation-message">
            Gracias por tu compra. Tu pedido ha sido procesado correctamente.<br>
            Hemos enviado un correo electrónico con los detalles de tu pedido a tu dirección de email.<br>
            Número de pedido: <span class="order-number">#<?php echo rand(10000, 99999); ?></span>
        </p>
        
        <div class="confirmation-actions">
            <a href="/Akihabara-Dreams/src/" class="confirmation-button secondary">Volver a la Tienda</a>
            <a href="/Akihabara-Dreams/src/views/myAccount.php" class="confirmation-button">Ver Mis Pedidos</a>
        </div>
    </div>
</body>
</html>

<?php include("../includes/footer.php"); ?>