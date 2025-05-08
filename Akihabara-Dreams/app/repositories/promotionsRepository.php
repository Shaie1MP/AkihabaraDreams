<?php

class PromotionsRepository {
    private PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function getAllPromotions() {
        $statement = $this->connection->prepare('select * from Promotion order by end_date desc');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $promotions = [];
        foreach ($result as $item) {
            $promotions[] = new Promotion(
                $item['id_promotion'],
                $item['code'],
                $item['discount'],
                $item['description'],
                $item['start_date'],
                $item['end_date']
            );
        }

        return $promotions;
    }

    public function getActivePromotions() {
        $today = date('Y-m-d');
        $statement = $this->connection->prepare('select * from Promotion 
                                                 where start_date <= :today and end_date >= :today 
                                                 order by discount desc');
        $statement->execute(['today' => $today]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $promotions = [];
        foreach ($result as $item) {
            $promotions[] = new Promotion(
                $item['id_promotion'],
                $item['code'],
                $item['discount'],
                $item['description'],
                $item['start_date'],
                $item['end_date']
            );
        }

        return $promotions;
    }

    public function getPromotionById($id) {
        try {
            $sql = 'select * from Promotion where id_promotion = :id';
            
            $statement = $this->connection->prepare($sql);
            $statement->execute(['id' => $id]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
    
            if (!$result) {
                throw new Exception('Promoción no encontrada con ID: ' . $id);
            }
    
            return new Promotion(
                $result['id_promotion'],
                $result['code'],
                $result['discount'],
                $result['description'],
                $result['start_date'],
                $result['end_date']
            );
        } catch (PDOException $e) {
            throw new Exception('Error de base de datos: ' . $e->getMessage());
        }
    }

    public function getProductsInPromotion($promotionId) {
        $statement = $this->connection->prepare('
            select p.* from Products p
            inner join Product_promotions pp on p.id_product = pp.id_product
            where pp.id_promotion = :id_promotion
        ');
        $statement->execute(['id_promotion' => $promotionId]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($result as $item) {
            $product = new Product(
                $item['id_product'],
                $item['name'],
                $item['price'],
                $item['photo'],
                $item['description'],
                $item['stock'],
                $item['category']
            );

            // Obtener fotos adicionales
            $photoStatement = $this->connection->prepare('select * from Product_photos where id_product = :id_product');
            $photoStatement->execute(['id_product' => $item['id_product']]);
            $photos = $photoStatement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($photos as $photo) {
                $product->addPhotos($photo['photo']);
            }

            $products[] = $product;
        }

        return $products;
    }

    public function getProductsWithPromotions() {
        $statement = $this->connection->prepare('
            select p.*, pr.discount, pr.id_promotion, pr.code, pr.description as promo_description, 
                   pr.start_date, pr.end_date,
                   round(p.price * (1 - (pr.discount / 100)), 2) as discounted_price
            from Products p
            inner join Product_promotions pp on p.id_product = pp.id_product
            inner join Promotion pr on pp.id_promotion = pr.id_promotion
            where pr.start_date <= CURRENT_DATE and pr.end_date >= CURRENT_DATE
            order by pr.discount desc, p.id_product
        ');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($result as $item) {
            $product = new Product(
                $item['id_product'],
                $item['name'],
                $item['price'],
                $item['photo'],
                $item['description'],
                $item['stock'],
                $item['category']
            );

            // Añadir información de promoción como propiedades adicionales
            $product->promotion = [
                'id' => $item['id_promotion'],
                'code' => $item['code'],
                'discount' => $item['discount'],
                'description' => $item['promo_description'],
                'start_date' => $item['start_date'],
                'end_date' => $item['end_date'],
                'discounted_price' => $item['discounted_price']
            ];

            // Obtener fotos adicionales
            $photoStatement = $this->connection->prepare('select * from Product_photos where id_product = :id_product');
            $photoStatement->execute(['id_product' => $item['id_product']]);
            $photos = $photoStatement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($photos as $photo) {
                $product->addPhotos($photo['photo']);
            }

            $products[] = $product;
        }

        return $products;
    }

    public function createPromotion(Promotion $promotion) {
        $this->connection->beginTransaction();
        try {
            $statement = $this->connection->prepare('
                insert into Promotion (code, discount, description, start_date, end_date) 
                values (:code, :discount, :description, :start_date, :end_date)
            ');
            $statement->execute([
                'code' => $promotion->getCode(),
                'discount' => $promotion->getDiscount(),
                'description' => $promotion->getDescription(),
                'start_date' => $promotion->getStartDate(),
                'end_date' => $promotion->getEndDate()
            ]);

            $promotionId = $this->connection->lastInsertId();
            $this->connection->commit();
            return $promotionId;
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception('Error al crear la promoción: ' . $e->getMessage());
        }
    }

    public function updatePromotion(Promotion $promotion) {
        $this->connection->beginTransaction();
        try {
            $statement = $this->connection->prepare('
                update Promotion set code = :code, discount = :discount, description = :description, 
                                     start_date = :start_date, end_date = :end_date
                where id_promotion = :id_promotion
            ');
            $statement->execute([
                'id_promotion' => $promotion->getId(),
                'code' => $promotion->getCode(),
                'discount' => $promotion->getDiscount(),
                'description' => $promotion->getDescription(),
                'start_date' => $promotion->getStartDate(),
                'end_date' => $promotion->getEndDate()
            ]);

            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception('Error al actualizar la promoción: ' . $e->getMessage());
        }
    }

    public function deletePromotion($id) {
        $this->connection->beginTransaction();
        try {
            // Primero eliminamos las relaciones en la tabla de productos_promociones
            $statement = $this->connection->prepare('delete from Product_promotions where id_promotion = :id');
            $statement->execute(['id' => $id]);
            
            // Luego eliminamos la promoción
            $statement = $this->connection->prepare('delete from Promotion where id_promotion = :id');
            $statement->execute(['id' => $id]);
            
            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception('Error al eliminar la promoción: ' . $e->getMessage());
        }
    }

    public function addProductToPromotion($productId, $promotionId) {
        $this->connection->beginTransaction();
        try {
            // Primero verificamos si ya existe esta relación
            $checkStatement = $this->connection->prepare('
                select count(*) from Product_promotions 
                where id_product = :id_product and id_promotion = :id_promotion
            ');
            $checkStatement->execute([
                'id_product' => $productId,
                'id_promotion' => $promotionId
            ]);
            
            if ($checkStatement->fetchColumn() > 0) {
                $this->connection->rollBack();
                return false; 
            }

            $statement = $this->connection->prepare('
                insert into Product_promotions (id_product, id_promotion) 
                values (:id_product, :id_promotion)
            ');

            $statement->execute([
                'id_product' => $productId,
                'id_promotion' => $promotionId
            ]);

            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception('Error al añadir producto a la promoción: ' . $e->getMessage());
        }
    }

    public function removeProductFromPromotion($productId, $promotionId) {
        $this->connection->beginTransaction();
        try {
            $statement = $this->connection->prepare('
                delete from Product_promotions 
                where id_product = :id_product and id_promotion = :id_promotion
            ');

            $statement->execute([
                'id_product' => $productId,
                'id_promotion' => $promotionId
            ]);

            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception('Error al eliminar producto de la promoción: ' . $e->getMessage());
        }
    }

    public function getPromotionsForProduct($productId) {
        try {
            $statement = $this->connection->prepare('
                SELECT pr.* FROM Promotion pr
                INNER JOIN Product_promotions pp ON pr.id_promotion = pp.id_promotion
                WHERE pp.id_product = :id_product 
                AND pr.start_date <= CURRENT_DATE 
                AND pr.end_date >= CURRENT_DATE
                ORDER BY pr.discount DESC
            ');
            $statement->execute(['id_product' => $productId]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
            $promotions = [];
            foreach ($result as $item) {
                $promotions[] = new Promotion(
                    $item['id_promotion'],
                    $item['code'],
                    $item['discount'],
                    $item['description'],
                    $item['start_date'],
                    $item['end_date']
                );
            }
    
            return $promotions;
        } catch (Exception $e) {
            error_log('Error al obtener promociones para el producto: ' . $e->getMessage());
            return [];
        }
    }
}