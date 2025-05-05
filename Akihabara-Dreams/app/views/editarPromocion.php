<?php
include '../app/includes/comprobarSesion.php';
include '../app/includes/comprobarRol.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Promoción - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/admin.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/adminTablas.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/promociones.css">
</head>

<body>
    <?php include '../resources/commons/navbar.php'; ?>
    
    <div class="admin-container">
        <!-- Sidebar de administración -->
        <div class="admin-sidebar">
            <div class="admin-sidebar-header">
                <h2>Panel de Control</h2>
            </div>
            <ul class="admin-sidebar-menu">
                <li class="admin-sidebar-item">
                    <a href="/Akihabara-Dreams/admin" class="admin-sidebar-link">
                        <span class="admin-sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard">
                                <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                                <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                                <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                                <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                            </svg>
                        </span>
                        Dashboard
                    </a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="/Akihabara-Dreams/productos" class="admin-sidebar-link">
                        <span class="admin-sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package">
                                <path d="m7.5 4.27 9 5.15"></path>
                                <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                                <path d="m3.3 7 8.7 5 8.7-5"></path>
                                <path d="M12 22V12"></path>
                            </svg>
                        </span>
                        Productos
                    </a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="/Akihabara-Dreams/usuarios" class="admin-sidebar-link">
                        <span class="admin-sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </span>
                        Usuarios
                    </a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="/Akihabara-Dreams/promociones" class="admin-sidebar-link active">
                        <span class="admin-sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag">
                                <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"></path>
                                <path d="M7 7h.01"></path>
                            </svg>
                        </span>
                        Promociones
                    </a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="/Akihabara-Dreams/pedidos" class="admin-sidebar-link">
                        <span class="admin-sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                <path d="M3 6h18"></path>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                        </span>
                        Pedidos
                    </a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="/Akihabara-Dreams/" class="admin-sidebar-link">
                        <span class="admin-sidebar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-store">
                                <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path>
                                <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"></path>
                                <path d="M2 7h20"></path>
                                <path d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"></path>
                            </svg>
                        </span>
                        Ir a la Tienda
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contenido principal -->
        <div class="admin-content">
            <div class="admin-header">
                <h1>Editar Promoción</h1>
                <p>Modifica los detalles de la promoción</p>
            </div>

            <div class="admin-form-container">
                <form action="/Akihabara-Dreams/promociones/update" method="post" class="admin-form">
                    <input type="hidden" name="id" value="<?= $promotion->getId() ?>">
                    
                    <div class="admin-form-group">
                        <label for="code">Código de Promoción:</label>
                        <input type="text" id="code" name="code" required value="<?= htmlspecialchars($promotion->getCode()) ?>">
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="discount">Descuento (%):</label>
                        <input type="number" id="discount" name="discount" min="1" max="100" required value="<?= $promotion->getDiscount() ?>">
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="description">Descripción:</label>
                        <input type="text" id="description" name="description" required value="<?= htmlspecialchars($promotion->getDescription()) ?>">
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="start_date">Fecha de Inicio:</label>
                        <input type="date" id="start_date" name="start_date" required value="<?= $promotion->getStartDate() ?>">
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="end_date">Fecha de Fin:</label>
                        <input type="date" id="end_date" name="end_date" required value="<?= $promotion->getEndDate() ?>">
                    </div>
                    
                    <div class="admin-form-actions">
                        <button type="submit" class="admin-btn admin-btn-primary">Actualizar Promoción</button>
                        <a href="/Akihabara-Dreams/promociones" class="admin-btn admin-btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>