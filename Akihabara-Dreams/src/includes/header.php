<nav class="navbar">
    <div class="navbar-container">
        <div>
            <button class="menu-button"><img src="../resources/images/commons/menu.png" alt="menu"></button>
        </div>
        <div class="navbar-logo-div">
            <a href="/Akihabara-Dreams/src/" class="navbar-logo">Akihabara Dreams</a>
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