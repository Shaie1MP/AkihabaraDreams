<?php
if(unserialize($_SESSION['usuario'])->getRole()!=='admin'){
    header('Location: /Akihabara-Dreams/myaccount');
    die;
}