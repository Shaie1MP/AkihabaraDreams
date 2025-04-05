<?php
$dsn = 'mysql:host=localhost;dbname=akihabaradreams;charset=utf8';
$username = 'root';
$password = '';
$connection = new PDO($dsn, $username, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);