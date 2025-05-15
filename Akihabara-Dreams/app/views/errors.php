<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Errores</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/errores.css">
</head>
<body>
    <?php include '../resources/commons/navbar.php';?>
    <div class="container">
        <h1 class="error-title">Listado de Errores</h1>
        <p class="error-description">Aquí puedes ver los errores registrados:</p>
        <ul class="error-list">
            <?php foreach ($errors as $error): ?>
                <li class="error-item">
                    <p><?php echo htmlspecialchars($error); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="/Akihabara-Dreams/" class="error-button">Volver al inicio</a>
    </div>
        

</body>
</html>
