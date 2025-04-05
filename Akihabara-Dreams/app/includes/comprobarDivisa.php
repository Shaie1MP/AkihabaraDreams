<?php

if (isset($_COOKIE['divisa'])) {
    $currency = strtolower($_COOKIE['divisa']);
    if ($currency == 'usd') {
        $symbol = '$';
        $convertion = 1.07;
    } else if ($currency == 'gbp') {
        $symbol = '£';
        $convertion = 0.83;
    } else {
        $symbol = '€';
    }
}else {
    setcookie('divisa', 'eur', time()+3600*24*7, '/');
    $symbol = '€';
    $currency='eur';
}

