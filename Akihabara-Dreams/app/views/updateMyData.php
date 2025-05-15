<?php
include '../app/includes/checkSession.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Mis Datos - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/form.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/information.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
</head>
<body>
<?php include '../resources/commons/navbar.php'; ?>

    <div class="container">
        <h1><?php echo __('account_data') ?></h1>
        <?php
        $user = unserialize($_SESSION['usuario']);
        include '../app/includes/generateFormUpdateAccount.php';
        ?>
    </div>
        

</body>
</html>
