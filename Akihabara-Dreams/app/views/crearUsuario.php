<?php
include '../app/includes/comprobarSesion.php';
include '../app/includes/comprobarRol.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/admin.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/adminTablas.css">
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
                    <a href="/Akihabara-Dreams/usuarios" class="admin-sidebar-link active">
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
                <h1>Crear Usuario</h1>
                <p>Añade un nuevo usuario a la plataforma</p>
            </div>

            <div class="admin-form-container">
                <form action="/Akihabara-Dreams/usuarios/create" method="post" enctype="multipart/form-data" class="admin-form">
                    <div class="admin-form-section">
                        <h2 class="admin-form-section-title">Información Obligatoria</h2>
                        <div class="admin-form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="username">Nombre de usuario:</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="email">Correo electrónico:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="confirm_password">Confirmar contraseña:</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="admin-form-group">
                            <label for="address">Dirección:</label>
                            <textarea id="address" name="address" required></textarea>
                        </div>
                    </div>

                    <div class="admin-form-section">
                        <h2 class="admin-form-section-title">Información Opcional</h2>
                        <div class="admin-form-group">
                            <label for="address2">Dirección adicional 1:</label>
                            <textarea id="address2" name="address2"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label for="address3">Dirección adicional 2:</label>
                            <textarea id="address3" name="address3"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label for="phone">Teléfono:</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        <div class="admin-form-group">
                            <label for="profilePic">Foto de perfil:</label>
                            <input type="file" id="profilePic" name="profilePic" accept="image/*">
                        </div>
                        <div class="admin-form-group">
                            <label for="role">Rol</label>
                            <select name="role" id="role">
                                <option value="usuario">Usuario</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="admin-btn admin-btn-primary">Registrar Usuario</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>