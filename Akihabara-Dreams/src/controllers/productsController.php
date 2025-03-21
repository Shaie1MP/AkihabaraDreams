<?php
class ProductsController {
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository) {
        $this->productsRepository = $productsRepository;
    }

    public function insertProduct(Product $product) {
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
    
        // Verificar si hay fotos adicionales
        $finalPhotos = [];
        if (isset($_FILES['additionalPhotos']) && !empty($_FILES['additionalPhotos']['name'][0])) {
            $photosExtra = $this->manipulateAdditionalPhotos($_FILES['additionalPhotos']);
            
            foreach ($photosExtra as $item) {
                if ($item['error'] != null) {
                    array_push($errors, $item['error']);
                }
    
                if (isset($item['nombre']) && $item['nombre'] != null && $item['tmp_name'] != null) {
                    $finalPhotos[] = ['name' => $item['nombre'], 'tmp_name' => $item['tmp_name']];
                }
            }
        }
    
        // Verificar la foto principal
        $photo = $_FILES['photo'] ?? null;
        $photoInfo = null;
        $newName = 'default.jpg';
        $rute = '../../resources/images/productos/portadas/';
    
        if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
            $photoInfo = pathinfo($photo['name']);
    
            if (!is_dir($rute)) {
                mkdir($rute, 0777, true);
            }
    
            if (!in_array(strtolower($photoInfo['extension']), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'heif', 'heic'])) {
                array_push($errors, 'La extensión no es correcta');
            } else {
                $newName = $product->getName() . "." . $photoInfo['extension'];
            }
        } else if ($photo) {
            array_push($errors, 'No se ha subido la imagen o ha ocurrido un error');
        } else {
            array_push($errors, 'No se ha proporcionado una imagen principal');
        }
    
        if (empty($errors)) {
            // Añadir fotos adicionales al producto
            if (!empty($finalPhotos)) {
                foreach ($finalPhotos as $item) {
                    $product->addPhotos($item['name']);
                }
            }
    
            // Insertar producto en la base de datos
            $this->productsRepository->insertProducts($product, $newName);
    
            // Mover la foto principal
            if (!move_uploaded_file($photo['tmp_name'], $rute . $newName)) {
                throw new Exception('No se ha podido guardar la foto principal.');
            }
    
            // Mover fotos adicionales
            if (!empty($finalPhotos)) {
                $additionalRoute = '../../resources/images/productos/adicionales/';
                
                if (!is_dir($additionalRoute)) {
                    mkdir($additionalRoute, 0777, true);
                }
    
                foreach ($finalPhotos as $item) {
                    if (!move_uploaded_file($item['tmp_name'], $additionalRoute . $item['name'])) {
                        throw new Exception('No se ha podido guardar una imagen adicional');
                    }
                }
            }
            
            return true;
        } else {
            // Mostrar errores
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
            return false;
        }
    }

    public function manipulateAdditionalPhotos(array $photos) {
        $photosExtra = [];
    
        if (!isset($photos['error']) || !isset($photos['name']) || !isset($photos['tmp_name'])) {
            return $photosExtra;
        }
    
        foreach ($photos['error'] as $key => $error) {
            if ($error == 0 && isset($photos['name'][$key]) && !empty($photos['name'][$key])) {
                $photoInfo = pathinfo($photos['name'][$key]);
                
                if (isset($photoInfo['extension']) && 
                    in_array(strtolower($photoInfo['extension']), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg', 'heif', 'heic'])) {
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
            $rute = '../resources/images/productos/portadas/';

            if (file_exists($rute.$product->getPhoto())) {
                if (!unlink($rute.$product->getPhoto())) {
                    throw new Exception('No se ha podido eliminar la foto principal');
                }
            }

            $rute = '../../resources/images/productos/adicionales/';
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
                $rute = '../../resources/images/productos/portadas/';
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
                    $rute = '../resources/images/productos/adicionales/';

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