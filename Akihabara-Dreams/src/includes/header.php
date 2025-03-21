<nav class="navbar">
    <div class="navbar-container">
        <div>
            <button id="menu-toggle" class="menu-button" aria-label="Abrir menú">
                <img src="../resources/images/commons/menu.png" alt="menu">
            </button>
        </div>
        <div class="navbar-logo-div">
            <a href="/Akihabara-Dreams/src/"><img src="../resources/images/commons/logo-AD-3.png" alt="logo" class="img-logo"></a>
        </div>
        <div>
            <ul class="navbar-menu">
                <li><a href="/Akihabara-Dreams/admin" class="navbar-link">Administración</a></li>
                <li><a href="/Akihabara-Dreams/catalogo" class="navbar-link">Catálogo</a></li>
                <li><a href="/Akihabara-Dreams/micuenta"
                    class="navbar-link"><?php echo isset($_SESSION['user']) ? htmlspecialchars(unserialize($_SESSION['user'])->getNombreUsuario()) : 'Cuenta'; ?></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal de navegación lateral -->
<div id="sidebar-modal" class="sidebar-modal">
    <div class="sidebar-content">
        <div class="sidebar-header">
            <h2>Menú</h2>
            <button id="close-sidebar" class="close-sidebar" aria-label="Cerrar menú">&times;</button>
        </div>
        <div class="sidebar-body">
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/src/" class="sidebar-link">
                        <span>Inicio</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/micuenta" class="sidebar-link">
                        <span>Mi Cuenta</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/catalogo/mangas" class="sidebar-link">
                        <span>Mangas</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/catalogo/figuras" class="sidebar-link">
                        <span>Figuras</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/catalogo/merchandising" class="sidebar-link">
                        <span>Merchandising</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/carrito" class="sidebar-link">
                        <span>Carrito</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/promociones" class="sidebar-link">

                        <span>Promociones</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/contacto" class="sidebar-link">
                        <span>Contacto</span>
                    </a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
                <li class="sidebar-menu-item">
                    <a href="/Akihabara-Dreams/logout" class="sidebar-link">
                        <span>Cerrar Sesión</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<!-- Overlay para oscurecer el fondo cuando el modal está abierto -->
<div id="overlay" class="overlay"></div>