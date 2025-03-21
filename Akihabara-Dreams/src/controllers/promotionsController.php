<?php
class PromotionsController {
    private PromotionsRepository $promotionsRepository;

    public function __construct(PromotionsRepository $promotionsRepository) {
        $this->promotionsRepository = $promotionsRepository;
    }

    public function insertPromotion(promotion $promotion, array $productIds = []) {
        $errors = [];

        // Validaciones

        if (!$promotion->getCode()) {
            $errors[] = "No has introducido el código de la promoción";
        }

        if (strlen($promotion->getCode()) < 5 && strlen($promotion->getCode()) > 15) {
            $errors[] = "El código de la promoción debe contener al menos 5 caracteres y no superar los 15";
        }

        if (!$promotion->getDiscount()) {
            $errors[] = "No has introducido el descuento de la promoción";
        }

        if ($promotion->getDiscount() <= 0) {
            $errors[] = "El descuento no puede ser negativo o igual a 0";
        }

        if ($promotion->getDiscount() > 100) {
            $errors[] = "El descuento no puede ser mayor del 100%";
        }

        if (!$promotion->getDescription()) {
            $errors[] = "No has introducido la descripción de la promoción";
        }

        if (strlen($promotion->getDescription()) > 50) {
            $errors[] = "La descripción no puede tener más de 50 caracteres";
        }

        if (empty($errors)) {
            $this->promotionsRepository->insertPromotion($promotion, $productIds);
        } else {
            foreach ($errors as $error) {
                echo "Error: $error";
            }
            //include("../src/views/errors.php");
        }
    }

    public function updatePromotion(promotion $promotion) {
        $errors = [];

        // Validaciones

        if (!$promotion->getCode()) {
            $errors[] = "No has introducido el código de la promoción";
        }

        if (strlen($promotion->getCode()) < 5 && strlen($promotion->getCode()) > 15) {
            $errors[] = "El código de la promoción debe contener al menos 5 caracteres y no superar los 15";
        }

        if (!$promotion->getDiscount()) {
            $errors[] = "No has introducido el descuento de la promoción";
        }

        if ($promotion->getDiscount() <= 0) {
            $errors[] = "El descuento no puede ser negativo o igual a 0";
        }

        if ($promotion->getDiscount() > 100) {
            $errors[] = "El descuento no puede ser mayor del 100%";
        }

        if (!$promotion->getDescription()) {
            $errors[] = "No has introducido la descripción de la promoción";
        }

        if (strlen($promotion->getDescription()) > 50) {
            $errors[] = "La descripción no puede tener más de 50 caracteres";
        }

        if (empty($errors)) {
            $this->promotionsRepository->updatePromotion($promotion);
        } else {
            //include("../src/views/errors.php");
        }
    }

    public function deletePromotion($id) {
        $errors = [];

        // Validaciones
        if (!$id) {
            $errors[] = 'No has introducido el id';
        }

        if ($id < 1) {
            $errors[] = 'El id no puede ser menor a 1';
        }

        if (empty($errors)) {
            $this->promotionsRepository->deletePromotion($id);
        } else {
            //include("../src/views/errors.php");
        }
    }

    public function showPromotions() {
        $promotions = $this->promotionsRepository->showPromotions();
    
        //include("../src/views/errors.php");
    }

    public function searchPromotion($id) {
        $errors = [];

        // Validaciones
        if (!$id) {
            $errors[] = 'No has introducido el id';
        }

        if ($id < 1) {
            $errors[] = 'El id no puede ser menor a 1';
        }

        if (empty($errors)) {
            $this->promotionsRepository->searchPromotion($id);
        } else {
            //include("../src/views/errors.php");
        }
    }
}