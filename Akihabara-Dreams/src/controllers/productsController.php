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
            $errors[] = 'No has introducido el nombre del producto';
        } else if (strlen($product->getName()) < 3) {
            $errors[] = 'El nombre debe tener como mínimo 3 caracteres';
        }

        if (!$product->getDescription()) {
            $errors[] = 'No has introducido la descripción del producto';
        }

        if (!$product->getPrice()) {
            $errors[] = 'No has introducido el precio del producto';
        } else if ($product->getPrice() < 0) {
            $errors[] = 'El precio no puede ser negativo';
        }

        if (!$product->getStock()) {
            $errors[] = 'No has introducido el stock del producto';
        } else if ($product->getStock() < 0) {
            $errors[] = 'El stock no puede ser negativo';
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

        $photo = $_FILES['main_photo'] ?? null;

        if ($photo) {
            if ($photo['error'] === UPLOAD_ERR_OK) {
                $rute = '../resources/images/productos/';
                $photoInfo = pathinfo($photo['name']);

                if (!is_dir($rute)) {
                    mkdir($rute, 0777, true);
                }

                if (!in_array($photoInfo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'heif', 'heic'])) {
                    array_push($errors, 'La extensión no es correcta');
                }
            } else {
                array_push($errors, 'No se ha subido la imagen');
            }
        }

        if (empty($errors)) {
            if (!empty($finalPhotos)) {
                foreach ($finalPhotos as $item) {
                    $product->addPhotos($item['name']);
                }
            }
            $newName = $product->getName() . "." . $photoInfo['extension'];
            $this->productsRepository->insertProducts($product, $newName);

            if (!move_uploaded_file($photo['tmp_name'], $rute . $newName)) {
                throw new Exception('No se ha podido guardar la foto.');
            }

            $rute = '../resources/images/productos/';

            foreach ($finalPhotos as $item) {
                if (!move_uploaded_file($item['tmp_name'], $rute . $item['name'])) {
                    throw new Exception('No se ha podido guardar la imagen');

                }
            }
            //header('Location: /akihabaraDreams/products');
            //exit;
        } else {
            //include '../src/views/errors.php';
        }
    }

    public function manipulateAdditionalPhotos(array $photos) {
        $photosExtra = [];

        foreach ($photos['error'] as $key => $error) {
            if ($error == 0) {
                $photoInfo = pathinfo($photos['name'][$key]);

                if (in_array($photoInfo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'heif', 'heic'])) {
                    $id = uniqid("", true);
                    $newName = $id . "." . $photoInfo['extension'];
                    array_push($photosExtra, ['tmp_name' => $photos['tmp_name'][$key], 'nombre' => $newName, 'error' => null]);
                } else {
                    array_push($photosExtra, ['tmp_name' => null, 'nombre' => null, 'error' => 'Alguna de las fotos no tiene la extensión correcta.']);
                }
            } else if ($error != 4) {
                array_push($photosExtra, ['tmp_name' => null, 'nombre' => null, 'error' => 'Ha habido una foto errónea.']);
            }
        }
        return $photosExtra;
    }

    public function deleteProduct($id) {
        $errors = [];

        if ($id == null) {
            array_push($errors, 'El ID no puede ser nulo');
        } else if ($id < 1) {
            array_push($errors, 'El ID no puede ser menor de 1');
        }

        if (empty($errors)) {
            $product = $this->productsRepository->deleteProduct($id);
            $rute = '../resources/images/productos/';

            if (file_exists($rute.$product->getPhoto())) {
                if (!unlink($rute.$product->getPhoto())) {
                    throw new Exception('No se ha podido eliminar la foto principal');
                }
            }

            $rute = '../resources/images/productos/';
            foreach ($product->getAdditionalPhotos() as $item) {
                if (file_exists($rute.$item)) {
                    if (!unlink($rute.$item)) {
                        throw new Exception('No se ha podido eliminar la foto adicional');
                    }
                }
            }

            //header('Location: /akihabaraDreams/products');
            //exit;
        } else {
            //include '../src/views/errors.php';
        }
    }

    public function updateProduct(Product $product) {
        $errors = [];

        if ($product->getId() == null) {
            $errors[] = 'El campo ID no puede ser nulo.';
        } else if ($product->getId() < 1) {
            $errors[] = 'El campo ID no puede ser menor de 1.';
        }

        if (!$product->getName()) {
            $errors[] = 'No has introducido el nombre del producto';
        } else if (strlen($product->getName()) < 3) {
            $errors[] = 'El nombre debe tener como mínimo 3 caracteres';
        }

        if (!$product->getDescription()) {
            $errors[] = 'No has introducido la descripción del producto';
        }

        if (!$product->getPrice()) {
            $errors[] = 'No has introducido el precio del producto';
        } else if ($product->getPrice() < 0) {
            $errors[] = 'El precio no puede ser negativo';
        }

        if (!$product->getStock()) {
            $errors[] = 'No has introducido el stock del producto';
        } else if ($product->getStock() < 0) {
            $errors[] = 'El stock no puede ser negativo';
        }

        $photo = $_FILES['main_photo'] ?? null;
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
                $rute = '../resources/images/productos/';
                $photoInfo = pathinfo($photo['name']);

                if (!is_dir($rute)) {
                    mkdir($rute, 0777, true);
                }

                if (!in_array($photoInfo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'heif', 'heic'])) {
                    array_push($errors, 'La extensión no es correcta');
                } else {
                    $newName = $product->getName() . "." . $photoInfo['extension'];
                    $flag = true;
                }
            } else if ($photo['error'] !== 4) {
                array_push($errors, 'No se ha subido la imagen');
            } else {
                $newName = $product->getPhoto();
            }
        }

        if (empty($errors)) {
            if (!empty($finalPhotos)) {
                foreach ($finalPhotos as $item) {
                    $product->addPhotos($item['name']);
                }
            }

            if ($this->productsRepository->updateProduct($product, $newName)) {
                if ($flag) {
                    if (!move_uploaded_file($photo['tmp_name'], $rute . $newName)) {
                        throw new Exception('No se ha podido guardar la foto');
                    }
                }

                if (!empty($finalPhotos)) {
                    $rute = '../resources/images/productos/';

                    foreach ($finalPhotos as $item) {
                        if (!move_uploaded_file($photo['tmp_name'], $rute . $newName)) {
                            throw new Exception('No se ha podido guardar la foto');
                        }
                    }
                }

                //header('Location: /akihabaraDreams/products');
                //exit;
            } else {
                throw new Exception('No se ha podido modificar el producto');
            }
        } else {
            //include '../src/views/errors.php';
        }
    }

    public function searchProduct($id) {
        $errors = [];

        // Validaciones
        if ($id == null) {
            $errors[] = 'El ID no puede ser nulo';
        } else if ($id < 1) {
            $errors[] = 'El ID no puede ser menor de 1';
        }

        if (empty($errors)) {
            $product = $this->productsRepository->searchProduct($id);
            //include '../src/views/product.php';
        } else {
            //include '../src/views/errors.php';
        }
    }

    public function getProducts() {
        $product = $this->productsRepository->getProducts();
        include '../src/views/showProducts.php';
    }
}