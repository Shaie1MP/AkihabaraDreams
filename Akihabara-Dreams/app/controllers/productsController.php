<?php

class ProductsController {
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository) {
        $this->productsRepository = $productsRepository;
    }

    public function addProduct(Product $product) {
        $errors = [];

        // Validaciones
        if (!$product->getName()) {
            array_push($errors, 'El Campo Nombre no puede estar vacío.');
        }

        if (!$product->getPrice()) {
            array_push($errors, 'El Campo Precio no puede estar vacío.');
        } else if ($product->getPrice() < 0) {
            array_push($errors, 'El precio del producto no puede ser menor que 0,');
        }

        if (!$product->getDescription()) {
            array_push($errors, 'El Campo Descripción Corta no puede estar vacío.');
        } else if (strlen($product->getDescription()) > 255) {
            array_push($errors, 'La descripción corta no puede tener más de 255 caracteres.');
        }

        if (!$product->getStock()) {
            array_push($errors, 'El Campo Stock Completa no puede estar vacío.');
        } else if ($product->getStock() < 0) {
            array_push($errors, 'El stock no puede ser menor a 0');
        }

        if (!$product->getCategory()) {
            array_push($errors, 'El Campo Categoría Completa no puede estar vacío.');
        }

        $photosExtra = $this->manipulateAdditionalPhotos($_FILES['additionalPhotos']);
        $finalPhotos = [];
        foreach ($photosExtra as $item) {
            if ($item['error'] != null) {
                array_push($errors, $item);
            }
            if ($item['name'] != null && $item['tmp_name'] != null) {
                $finalPhotos[] = ['name' => $item['name'], 'tmp_name' => $item['tmp_name']];
            }
        }
        $photo = $_FILES['photo'] ?? null;

        if ($photo) {
            if ($photo['error'] === UPLOAD_ERR_OK) {
                $route = BASE_PATH . '/resources/images/productos/portadas/';
                $route = str_replace('\\', '/', $route);
                $photoInfo = pathinfo($photo['name']);

                if (!is_dir($route)) {
                    mkdir($route, 0777, true);
                }

                if (!in_array($photoInfo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'heif', 'heic'])) {
                    array_push($errors, 'La extensión no es correcta.');
                }
            } else {
                array_push($errors, 'No se ha subido la imagen.');
            }
        }

        if (empty($errors)) {
            if (!empty($finalPhotos)) {
                foreach ($finalPhotos as $item) {
                    $product->addPhotos($item['name']);
                }
            }
            $newname = $product->getName() . "." . $photoInfo['extension'];

            $this->productsRepository->insertProduct($product, $newname);

            if (!move_uploaded_file($photo['tmp_name'], $route . $newname)) {
                throw new Exception('No se ha podido guardar la foto.');
            }

            $route = BASE_PATH . '/resources/images/productos/adicional/';
            $route = str_replace('\\', '/', $route);
            
            foreach ($finalPhotos as $item) {
                if (!move_uploaded_file($item['tmp_name'], $route . $item['name'])) {
                    throw new Exception('No se ha podido guardar la foto');
                }
            }

            header('Location: /Akihabara-Dreams/products');
            exit;
        } else {
            include '../app/views/errors.php';
        }

    }


    public function manipulateAdditionalPhotos(array $photos) {
        $photosExtra = [];

        foreach ($photos['error'] as $key => $error) {
            if ($error == 0) {
                $fotoInfo = pathinfo($photos['name'][$key]);

                if (in_array($fotoInfo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'heif', 'heic'])) {
                    $id = uniqid("", true);
                    $newname = $id . "." . $fotoInfo['extension'];

                    array_push($photosExtra, ['tmp_name' => $photos['tmp_name'][$key], 'name' => $newname, 'error' => null]);
                } else {
                    array_push($photosExtra, ['tmp_name' => null, 'name' => null, 'error' => 'Alguna de las fotos no tiene la extensión correcta.']);
                }
            } else if ($error != 4) {
                array_push($photosExtra, ['tmp_name' => null, 'name' => null, 'error' => 'Ha habido una foto errónea.']);
            }
        }
        return $photosExtra;
    }

    public function deleteProduct($id) {
        $errors = [];

        if ($id == null) {
            array_push($errors, 'El campo ID no puede ser nulo.');
        } else if ($id < 1) {
            array_push($errors, 'El campo ID no puede ser menor de 1.');
        }

        if (empty($errors)) {
            $product = $this->productsRepository->deleteProduct($id);
            $route = BASE_PATH . '/resources/images/productos/portadas/';
            $route = str_replace('\\', '/', $route);
            
            if(file_exists($route.$product->getPhoto())){
                if(!unlink($route.$product->getPhoto())){
                    throw new Exception('No se ha podido eliminar la foto de portada');
                }
            }
            $route = BASE_PATH . '/resources/images/productos/adicional/';
            $route = str_replace('\\', '/', $route);

            foreach($product->getAdditionalPhotos() as $item){
                if(file_exists($route.$item)){
                    if(!unlink($route.$item)){
                        throw new Exception('No se ha podido eliminar la foto adicional');
                    }
                }
            }

            header('Location: /Akihabara-Dreams/products');
            exit;
        } else {
            include '../app/views/errors.php';

        }
    }

    public function updateProduct(Product $product)
    {
        $errors = [];

        if ($product->getId() == null) {
            array_push($errors, 'El campo ID no puede ser nulo.');
        } else if ($product->getId() < 1) {
            array_push($errors, 'El campo ID no puede ser menor de 1.');
        }

        if (!$product->getName()) {
            array_push($errors, 'El Campo Nombre no puede estar vacío.');
        }

        if (!$product->getPrice()) {
            array_push($errors, 'El Campo Precio no puede estar vacío.');
        } else if ($product->getPrice() < 0) {
            array_push($errors, 'El precio del producto no puede ser menor que 0,');
        }

        if (!$product->getDescription()) {
            array_push($errors, 'El Campo Descripción no puede estar vacío.');
        } else if (strlen($product->getDescription()) > 255) {
            array_push($errors, 'La descripción no puede tener más de 255 caracteres.');
        }

        if (!$product->getStock()) {
            array_push($errors, 'El Campo Stock Completa no puede estar vacío.');
        } else if ($product->getStock() < 0) {
            array_push($errors, 'El stock no puede ser menor a 0');
        }

        if (!$product->getCategory()) {
            array_push($errors, 'El Campo Categoría Completa no puede estar vacío.');
        }

        $photo = $_FILES['photo'] ?? null;
        $photosExtra = $this->manipulateAdditionalPhotos($_FILES['additionalPhotos']);
        $finalPhotos = [];

        foreach ($photosExtra as $item) {
            if ($item['error'] != null) {
                array_push($errors, $item);
            }
            if ($item['name'] != null && $item['tmp_name'] != null) {
                $finalPhotos[] = ['name' => $item['name'], 'tmp_name' => $item['tmp_name']];
            }
        }

        $flag = false;

        if ($photo) {
            if ($photo['error'] === UPLOAD_ERR_OK) {
                $route = BASE_PATH . '/resources/images/productos/portadas/';
                $route = str_replace('\\', '/', $route);
                $photoInfo = pathinfo($photo['name']);

                if (!is_dir($route)) {
                    mkdir($route, 0777, true);
                }

                if (!in_array($photoInfo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'heif', 'heic'])) {
                    array_push($errors, 'La extensión no es correcta.');
                } else {
                    $newname = $product->getName() . "." . $photoInfo['extension'];
                    $flag = true;
                }

            } else if ($photo['error'] !== 4) {
                array_push($errors, 'No se ha subido la imagen.');
            } else {
                $newname = $product->getPhoto();
            }
        }

        if (empty($errors)) {
            if (!empty($finalPhotos)) {
                foreach ($finalPhotos as $item) {
                    $product->addPhotos($item['name']);
                }
            }

            if ($this->productsRepository->updateProduct($product, $newname)) {
                if ($flag) {
                    if (!move_uploaded_file($photo['tmp_name'], $route . $newname)) {
                        throw new Exception('No se ha podido guardar la foto.');
                    }
                }
                if (!empty($finalPhotos)) {
                    $route = BASE_PATH . '/resources/images/productos/adicional/';
                    $route = str_replace('\\', '/', $route);

                    foreach ($finalPhotos as $item) {
                        if (!move_uploaded_file($item['tmp_name'], $route . $item['name'])) {
                            throw new Exception('No se ha podido guardar la foto');

                        }
                    }
                }
                header('Location: /Akihabara-Dreams/products');
                exit;
            } else {
                throw new Exception('No se ha podido actualizar el producto');
            }
        } else {
            include '../app/views/errors.php';
        }
    }

    public function searchProduct($id) {
        $errors = [];
        if ($id == null) {
            array_push($errors, 'El campo ID no puede ser nulo.');
        } else if ($id < 1) {
            array_push($errors, 'El campo ID no puede ser menor de 1.');
        }
        if (empty($errors)) {
            $product = $this->productsRepository->searchProduct($id);
            include '../app/views/product.php';
        } else {
            include '../app/views/errors.php';
        }
    }

    public function showProducts() {
        $products = $this->productsRepository->showProducts();
        include '../app/views/showProducts.php';
    }
    public function createForm() {
        include '../app/views/createProduct.php';
    }

    public function updateForm($id) {
        $product = $this->productsRepository->searchProduct($id);
        include '../app/views/updateProduct.php';
    }
}
