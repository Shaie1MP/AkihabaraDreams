<?php
session_start();

require_once '../config/database.php';
require_once "../repositories/usersRepository.php";
require_once '../models/user.php';
require_once "../models/cart.php";

// Verificar si hay una sesión activa
if (!isset($_SESSION['user'])) {
    // Redirigir a login con parámetro de retorno
    header("Location: login.php?redirect=checkout");
    exit;
}

// Verificar si hay productos en el carrito
if (!isset($_SESSION['cart']) || empty(unserialize($_SESSION['cart'])->getCart())) {
    header("Location: cart.php");
    exit;
}

$userSesion = unserialize($_SESSION['user']);
$cart = unserialize($_SESSION['cart']);

include("../includes/header.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - Akihabara Dreams</title>
    <link rel="stylesheet" href="../../resources/css/navbar.css">
    <link rel="stylesheet" href="../../resources/css/index.css">
    <link rel="stylesheet" href="../../resources/css/form.css">
    <link rel="stylesheet" href="../../resources/css/cart.css">
    <style>
        .checkout-container {
            max-width: 1000px;
            margin: 30px auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        @media (min-width: 768px) {
            .checkout-container {
                grid-template-columns: 1.5fr 1fr;
            }
        }
        
        .checkout-form, .checkout-summary {
            background-color: var(--card-background);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        .checkout-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--secondary-color);
        }
        
        .checkout-section {
            margin-bottom: 30px;
        }
        
        .checkout-section-title {
            font-size: 1.2rem;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .payment-method {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-method:hover {
            border-color: var(--secondary-color);
            background-color: rgba(255, 99, 71, 0.05);
        }
        
        .payment-method.selected {
            border-color: var(--secondary-color);
            background-color: rgba(255, 99, 71, 0.1);
        }
        
        .payment-method input {
            margin-right: 15px;
        }
        
        .payment-method-details {
            display: none;
            margin-top: 15px;
            padding: 15px;
            background-color: var(--background-color);
            border-radius: 8px;
        }
        
        .payment-method.selected .payment-method-details {
            display: block;
        }
        
        .checkout-items {
            margin-bottom: 20px;
        }
        
        .checkout-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .checkout-item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
        }
        
        .checkout-item-details {
            flex: 1;
        }
        
        .checkout-item-name {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .checkout-item-price {
            display: flex;
            justify-content: space-between;
        }
        
        .checkout-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .checkout-summary-total {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
            font-size: 1.2rem;
            font-weight: bold;
        }
        
        .checkout-button {
            width: 100%;
            padding: 15px;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        
        .checkout-button:hover {
            background-color: #e5533e;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <div class="checkout-form">
            <h1 class="checkout-title">Finalizar Compra</h1>
            
            <div class="checkout-section">
                <h2 class="checkout-section-title">Dirección de Envío</h2>
                <form id="checkout-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="required-field">Nombre completo</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userSesion->getName()); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email" class="required-field">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userSesion->getEmail()); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="required-field">Teléfono</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($userSesion->getPhone()); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="address" class="required-field">Dirección</label>
                            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($userSesion->getAddress()); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="city" class="required-field">Ciudad</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="postal_code" class="required-field">Código Postal</label>
                            <input type="text" id="postal_code" name="postal_code" required>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="checkout-section">
                <h2 class="checkout-section-title">Método de Pago</h2>
                <div class="payment-methods">
                    <div class="payment-method" data-method="card">
                        <input type="radio" name="payment_method" id="card" value="card" checked>
                        <label for="card">Tarjeta de Crédito/Débito</label>
                    </div>
                    
                    <div class="payment-method" data-method="paypal">
                        <input type="radio" name="payment_method" id="paypal" value="paypal">
                        <label for="paypal">PayPal</label>
                    </div>
                    
                    <div class="payment-method" data-method="transfer">
                        <input type="radio" name="payment_method" id="transfer" value="transfer">
                        <label for="transfer">Transferencia Bancaria</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="checkout-summary">
            <h2 class="checkout-title">Resumen del Pedido</h2>
            
            <div class="checkout-items" id="checkout-items">
                <!-- Los items se cargarán dinámicamente con JavaScript -->
            </div>
            
            <div class="checkout-summary-row">
                <span>Subtotal</span>
                <span id="checkout-subtotal">€0.00</span>
            </div>
            
            <div class="checkout-summary-row">
                <span>Envío</span>
                <span id="checkout-shipping">€0.00</span>
            </div>
            
            <div class="checkout-summary-total">
                <span>Total</span>
                <span id="checkout-total">€0.00</span>
            </div>
            
            <button id="place-order" class="checkout-button">Realizar Pedido</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cargar carrito desde localStorage
            const savedCart = localStorage.getItem('akihabaraCart');
            let cart = [];
            
            if (savedCart) {
                cart = JSON.parse(savedCart);
                updateCheckoutSummary(cart);
            }
            
            // Actualizar resumen del pedido
            function updateCheckoutSummary(cart) {
                const checkoutItems = document.getElementById('checkout-items');
                const subtotalElement = document.getElementById('checkout-subtotal');
                const shippingElement = document.getElementById('checkout-shipping');
                const totalElement = document.getElementById('checkout-total');
                
                checkoutItems.innerHTML = '';
                
                let subtotal = 0;
                
                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    subtotal += itemTotal;
                    
                    const itemElement = document.createElement('div');
                    itemElement.className = 'checkout-item';
                    itemElement.innerHTML = `
                        <img src="/Akihabara-Dreams/resources/images/productos/portadas/${item.image}" alt="${item.name}" class="checkout-item-image">
                        <div class="checkout-item-details">
                            <div class="checkout-item-name">${item.name}</div>
                            <div class="checkout-item-price">
                                <span>${item.quantity} x ${item.price.toFixed(2)} €</span>
                                <span>€${itemTotal.toFixed(2)}</span>
                            </div>
                        </div>
                    `;
                    
                    checkoutItems.appendChild(itemElement);
                });
                
                // Calcular envío (gratis si el subtotal es mayor a 50€)
                const shipping = subtotal > 50 ? 0 : 4.99;
                const total = subtotal + shipping;
                
                subtotalElement.textContent = `${subtotal.toFixed(2)} €`;
                shippingElement.textContent = shipping === 0 ? 'Gratis' : `${shipping.toFixed(2)} €`;
                totalElement.textContent = `${total.toFixed(2)} €`;
            }
            
            // Manejar selección de método de pago
            const paymentMethods = document.querySelectorAll('.payment-method');
            
            paymentMethods.forEach(method => {
                method.addEventListener('click', function() {
                    // Desmarcar todos
                    paymentMethods.forEach(m => {
                        m.classList.remove('selected');
                        m.querySelector('input').checked = false;
                    });
                    
                    // Marcar el seleccionado
                    this.classList.add('selected');
                    this.querySelector('input').checked = true;
                });
            });
            
            // Manejar envío del formulario
            const placeOrderButton = document.getElementById('place-order');
            const checkoutForm = document.getElementById('checkout-form');
            
            placeOrderButton.addEventListener('click', function() {
                if (checkoutForm.checkValidity()) {
                    // Aquí iría la lógica para procesar el pedido
                    alert('¡Pedido realizado con éxito! Gracias por tu compra.');
                    
                    // Limpiar carrito
                    localStorage.removeItem('akihabaraCart');
                    
                    // Redirigir a página de confirmación
                    window.location.href = '/Akihabara-Dreams/src/views/order-confirmation.php';
                } else {
                    checkoutForm.reportValidity();
                }
            });
        });
    </script>
</body>
</html>

<?php include("../includes/footer.php"); ?>