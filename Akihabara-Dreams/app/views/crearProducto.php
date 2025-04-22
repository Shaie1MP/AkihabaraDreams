<?php
include '../app/includes/comprobarSesion.php';
include '../app/includes/comprobarRol.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Producto - Akihabara Dreams</title>
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/normalize.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/language-switcher.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/body.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/navbar.css">
    <link rel="stylesheet" href="/Akihabara-Dreams/resources/css/form.css">
</head>

<body>
    <?php include '../resources/commons/navbar.php'; ?>

    <div class="container">
        <h1>Registro de Producto</h1>
        <form action="/Akihabara-Dreams/productos/create" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nombre del producto:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Descripción corta:</label>
                <input type="text" id="description" name="description" required>
            </div>
            <div class="form-group">
                <label for="category">Categoría:</label>
                <textarea id="category" name="category" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="stock">Inventario:</label>
                <input type="number" id="stock" name="stock" required></input>
            </div>
            <div class="form-group">
                <label for="price">Precio:</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="photo">Foto principal del producto:</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="additionalPhotos">Fotos adicionales (opcional):</label>
                <input type="file" id="additionalPhotos" name="additionalPhotos[]" accept="image/*" multiple>
            </div>
            <button type="submit">Guardar Producto</button>
        </form>
    </div>
</body>

</html>