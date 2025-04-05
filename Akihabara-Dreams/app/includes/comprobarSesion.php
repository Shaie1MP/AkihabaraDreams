<?php
if(!isset($_SESSION['usuario'])){
    header('Location: /Akihabara-Dreams/login');
    die;
}