<?php

if (isset($_SESSION['tiempo'])) {
    if (time() - $_SESSION['tiempo'] > 60 * 60 * 24 * 7) {
        foreach ($_COOKIE as $item => $value) {
            setcookie($item, '', time() - 3600, '/');
        }
        session_unset();
        session_destroy();

        header('Location: /Akihabara-Dreams/');
        exit;
    }
}
$_SESSION['tiempo'] = time();