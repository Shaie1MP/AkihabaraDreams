<?php

class PromotionsController {
    private PromotionsRepository $promotionsRepository;
    private ProductsRepository $productsRepository;

    public function __construct(PromotionsRepository $promotionsRepository, ProductsRepository $productsRepository) {
        $this->promotionsRepository = $promotionsRepository;
        $this->productsRepository = $productsRepository;
    }

    public function index() {
        $promotions = $this->promotionsRepository->getAllPromotions();
        include '../app/views/mostrarPromociones.php';
    }

    public function showPromotionProducts($id) {
        $promotion = $this->promotionsRepository->getPromotionById($id);
        $products = $this->promotionsRepository->getProductsInPromotion($id);
        include '../app/views/mostrarProductosPromocion.php';
    }

    public function createForm() {
        include '../app/views/crearPromocion.php';
    }

    public function create() {
        $errors = [];

        $code = trim(strip_tags($_POST['code'] ?? ''));
        $discount = floatval($_POST['discount'] ?? 0);
        $description = trim(strip_tags($_POST['description'] ?? ''));
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';

        // Validaciones
        if (empty($code)) {
            $errors[] = 'El código de promoción es obligatorio';
        }

        if ($discount <= 0 || $discount > 100) {
            $errors[] = 'El descuento debe ser un número entre 1 y 100';
        }

        if (empty($description)) {
            $errors[] = 'La descripción es obligatoria';
        }

        if (empty($start_date)) {
            $errors[] = 'La fecha de inicio es obligatoria';
        }

        if (empty($end_date)) {
            $errors[] = 'La fecha de fin es obligatoria';
        }

        if (strtotime($start_date) > strtotime($end_date)) {
            $errors[] = 'La fecha de inicio no puede ser posterior a la fecha de fin';
        }

        if (empty($errors)) {
            $promotion = new Promotion(
                0, // ID será asignado por la base de datos
                $code,
                $discount,
                $description,
                $start_date,
                $end_date
            );

            $this->promotionsRepository->createPromotion($promotion);
            header('Location: /Akihabara-Dreams/promociones');
            exit;
        } else {
            include '../app/views/errores.php';
        }
    }

    public function editForm($id) {
        $promotion = $this->promotionsRepository->getPromotionById($id);
        include '../app/views/editarPromocion.php';
    }

    public function update() {
        $errors = [];

        $id = intval($_POST['id'] ?? 0);
        $code = trim(strip_tags($_POST['code'] ?? ''));
        $discount = floatval($_POST['discount'] ?? 0);
        $description = trim(strip_tags($_POST['description'] ?? ''));
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';

        // Validaciones
        if ($id <= 0) {
            $errors[] = 'ID de promoción inválido';
        }

        if (empty($code)) {
            $errors[] = 'El código de promoción es obligatorio';
        }

        if ($discount <= 0 || $discount > 100) {
            $errors[] = 'El descuento debe ser un número entre 1 y 100';
        }

        if (empty($description)) {
            $errors[] = 'La descripción es obligatoria';
        }

        if (empty($start_date)) {
            $errors[] = 'La fecha de inicio es obligatoria';
        }

        if (empty($end_date)) {
            $errors[] = 'La fecha de fin es obligatoria';
        }

        if (strtotime($start_date) > strtotime($end_date)) {
            $errors[] = 'La fecha de inicio no puede ser posterior a la fecha de fin';
        }

        if (empty($errors)) {
            $promotion = new Promotion(
                $id,
                $code,
                $discount,
                $description,
                $start_date,
                $end_date
            );

            $this->promotionsRepository->updatePromotion($promotion);
            header('Location: /Akihabara-Dreams/promociones');
            exit;
        } else {
            include '../app/views/errores.php';
        }
    }

    public function delete($id) {
        $this->promotionsRepository->deletePromotion($id);
        header('Location: /Akihabara-Dreams/promociones');
        exit;
    }

    public function addProductForm($id) {
        try {
            // Depuración: Mostrar el ID que estamos recibiendo
            echo "<!-- Debug: ID de promoción recibido: " . htmlspecialchars($id) . " -->";
            
            // Verificar que el ID es un número válido
            if (!is_numeric($id) || $id <= 0) {
                throw new Exception('ID de promoción inválido: ' . $id);
            }
            
            $promotion = $this->promotionsRepository->getPromotionById($id);
            
            // Si llegamos aquí, la promoción existe
            $products = $this->productsRepository->showProducts();
            $productsInPromotion = $this->promotionsRepository->getProductsInPromotion($id);
            
            // Filtrar productos que ya están en la promoción
            $productsInPromotionIds = array_map(function($product) {
                return $product->getId();
            }, $productsInPromotion);
            
            $availableProducts = array_filter($products, function($product) use ($productsInPromotionIds) {
                return !in_array($product->getId(), $productsInPromotionIds);
            });
            
            // Asegurarnos de que $availableProducts sea un array indexado
            $availableProducts = array_values($availableProducts);
            
            include '../app/views/agregarProductoPromocion.php';
        } catch (Exception $e) {
            throw new Exception('Error al mostrar el formulario de añadir producto: ' . $e->getMessage());
        }
    }
    
    public function addProduct() {
        try {
            $promotionId = isset($_POST['promotion_id']) ? intval($_POST['promotion_id']) : 0;
            $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    
            // Depuración
            echo "<!-- Debug: promotion_id = $promotionId, product_id = $productId -->";
    
            if ($promotionId <= 0) {
                throw new Exception('ID de promoción inválido o no proporcionado');
            }
    
            if ($productId <= 0) {
                throw new Exception('ID de producto inválido o no seleccionado');
            }
    
            // Verificar que la promoción existe
            $promotion = $this->promotionsRepository->getPromotionById($promotionId);
            
            // Verificar que el producto existe
            $product = $this->productsRepository->searchProduct($productId);
            
            // Añadir el producto a la promoción
            $result = $this->promotionsRepository->addProductToPromotion($productId, $promotionId);
            
            if ($result) {
                header('Location: /Akihabara-Dreams/promociones/productos/' . $promotionId);
                exit;
            } else {
                throw new Exception('No se pudo añadir el producto a la promoción');
            }
        } catch (Exception $e) {
            throw new Exception('Error al añadir el producto a la promoción: ' . $e->getMessage());
        }
    }

    public function removeProduct($promotionId, $productId) {
        $this->promotionsRepository->removeProductFromPromotion($productId, $promotionId);
        header('Location: /Akihabara-Dreams/promociones/productos/' . $promotionId);
        exit;
    }

    public function showPromotedProducts() {
        $products = $this->promotionsRepository->getProductsWithPromotions();
        include '../app/views/promociones.php';
    }
}