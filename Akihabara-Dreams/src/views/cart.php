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
    <title>Carrito de Compras - Akihabara Dreams</title>
    <link rel="stylesheet" href="../../resources/css/navbar.css">
    <link rel="stylesheet" href="../../resources/css/footer.css">
    <link rel="stylesheet" href="../../resources/css/index.css">
    <link rel="stylesheet" href="../../resources/css/products.css">
    <link rel="stylesheet" href="../../resources/css/cart.css">
</head>
<body>
    <div class="cart-container">
        <div class="cart-header">
            <h1>Tu Carrito de Compras</h1>
        </div>
        
        <div id="cart-content">
            <!-- El contenido del carrito se cargará dinámicamente con JavaScript -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartContent = document.getElementById('cart-content');
            
            // Cargar carrito desde localStorage
            const savedCart = localStorage.getItem('akihabaraCart');
            let cart = [];
            
            if (savedCart) {
                cart = JSON.parse(savedCart);
                updateCartPage(cart);
            } else {
                showEmptyCart();
            }
            
            // Mostrar carrito vacío
            function showEmptyCart() {
                cartContent.innerHTML = `
                    <div class="cart-empty">
                        <div class="cart-empty-message">Tu carrito está vacío</div>
                        <a href="/Akihabara-Dreams/src/" class="cart-empty-button">Continuar Comprando</a>
                    </div>
                `;
            }
            
            // Actualizar la página del carrito
            function updateCartPage(cart) {
                if (cart.length === 0) {
                    showEmptyCart();
                    return;
                }
                
                let cartHTML = '<div class="cart-items">';
                let subtotal = 0;
                
                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    subtotal += itemTotal;
                    
                    cartHTML += `
                        <div class="cart-item">
                            <img src="/Akihabara-Dreams/resources/images/productos/portadas/${item.image}" alt="${item.name}" class="cart-item-image">
                            <div class="cart-item-details">
                                <div class="cart-item-name">${item.name}</div>
                                <div class="cart-item-price">${item.price.toFixed(2)} €</div>
                                <div class="cart-item-quantity">
                                    <button class="decrease-quantity" data-id="${item.id}">-</button>
                                    <span>${item.quantity}</span>
                                    <button class="increase-quantity" data-id="${item.id}">+</button>
                                </div>
                            </div>
                            <div class="cart-item-subtotal">${itemTotal.toFixed(2)} €</div>
                            <button class="cart-item-remove" data-id="${item.id}">&times;</button>
                        </div>
                    `;
                });
                
                cartHTML += '</div>';
                
                // Añadir resumen del carrito
                const shipping = subtotal > 50 ? 0 : 4.99;
                const total = subtotal + shipping;
                
                cartHTML += `
                    <div class="cart-summary">
                        <div class="cart-summary-title">Resumen del Pedido</div>
                        <div class="cart-summary-row">
                            <span class="cart-summary-label">Subtotal</span>
                            <span class="cart-summary-value">${subtotal.toFixed(2)} €</span>
                        </div>
                        <div class="cart-summary-row">
                            <span class="cart-summary-label">Envío</span>
                            <span class="cart-summary-value">${shipping === 0 ? 'Gratis' : '' + shipping.toFixed(2)} €</span>
                        </div>
                        <div class="cart-summary-total">
                            <span>Total</span>
                            <span>${total.toFixed(2)} €</span>
                        </div>
                    </div>
                    
                    <div class="cart-actions">
                        <a href="/Akihabara-Dreams/src/" class="cart-button continue">Continuar Comprando</a>
                        <button id="clear-cart" class="cart-button clear">Vaciar Carrito</button>
                        <a href="/Akihabara-Dreams/src/views/checkout.php" class="cart-button checkout">Proceder al Pago</a>
                    </div>
                `;
                
                cartContent.innerHTML = cartHTML;
                
                // Añadir event listeners a los botones
                const decreaseButtons = cartContent.querySelectorAll('.decrease-quantity');
                const increaseButtons = cartContent.querySelectorAll('.increase-quantity');
                const removeButtons = cartContent.querySelectorAll('.cart-item-remove');
                const clearCartButton = document.getElementById('clear-cart');
                
                decreaseButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        decreaseQuantity(id);
                    });
                });
                
                increaseButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        increaseQuantity(id);
                    });
                });
                
                removeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        removeFromCart(id);
                    });
                });
                
                if (clearCartButton) {
                    clearCartButton.addEventListener('click', clearCart);
                }
            }
            
            // Aumentar cantidad de un producto
            function increaseQuantity(id) {
                const itemIndex = cart.findIndex(item => item.id === id);
                if (itemIndex !== -1) {
                    cart[itemIndex].quantity += 1;
                    localStorage.setItem('akihabaraCart', JSON.stringify(cart));
                    updateCartPage(cart);
                }
            }
            
            // Disminuir cantidad de un producto
            function decreaseQuantity(id) {
                const itemIndex = cart.findIndex(item => item.id === id);
                if (itemIndex !== -1) {
                    if (cart[itemIndex].quantity > 1) {
                        cart[itemIndex].quantity -= 1;
                    } else {
                        cart.splice(itemIndex, 1);
                    }
                    localStorage.setItem('akihabaraCart', JSON.stringify(cart));
                    updateCartPage(cart);
                }
            }
            
            // Eliminar producto del carrito
            function removeFromCart(id) {
                const itemIndex = cart.findIndex(item => item.id === id);
                if (itemIndex !== -1) {
                    cart.splice(itemIndex, 1);
                    localStorage.setItem('akihabaraCart', JSON.stringify(cart));
                    updateCartPage(cart);
                }
            }
            
            // Vaciar carrito
            function clearCart() {
                if (confirm('¿Estás seguro de que quieres vaciar el carrito?')) {
                    cart = [];
                    localStorage.setItem('akihabaraCart', JSON.stringify(cart));
                    updateCartPage(cart);
                }
            }
        });
    </script>
</body>
</html>

<?php include("../includes/footer.php"); ?>

