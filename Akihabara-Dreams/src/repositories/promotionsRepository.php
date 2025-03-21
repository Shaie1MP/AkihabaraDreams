<?php
class PromotionsRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function showPromotions() {
        $statement = $this->pdo->prepare("select * from Promotion");
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

    public function searchPromotion($id) {
        $statement = $this->pdo->prepare('select * from Promotion where id_promotion = :id:promotion');
        $statement->execute(['id_promotion'=> $id]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return new Promotion(
            $result['id_promotion'],
            $result['code'],
            $result['discount'],
            $result['description'],
            $result['start_date'],
            $result['end_date']
        );
    }

    public function updatePromotion(Promotion $promotion) {
        $this->pdo->beginTransaction();

        try {
            $statement = $this->pdo->prepare('update Promotion set code = :code,
                                                                    discount = :discount,
                                                                    description = :description,
                                                                    start_date = :start_date,
                                                                    end_date = :end_date
                                                    where id_promotion = :id_promotion');
            $statement->execute([
                'code'=> $promotion->getCode(),
                'discount'=> $promotion->getDiscount(),
                'description'=> $promotion->getDescription(),
                'start_date'=> $promotion->getStartDate(),
                'end_date'=> $promotion->getEndDate(),
                'id_promotion'=> $promotion->getPromotionId()
            ]);
            $this->pdo->commit();                
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception('No se ha podido actualizar la promoción');
        }
    }

    public function deletePromotion($id) {
        $statement = $this->pdo->prepare('delete from Promotion where id_promotion = :id_promotion');
        $statement->execute(['id_promotion'=> $id]);
    }

    public function insertPromotion(Promotion $promotion, array $productIds = []) {
        $this->pdo->beginTransaction();
    
        try {
            // Insertar la promoción
            $statement = $this->pdo->prepare('insert into Promotion (code, discount, description, start_date, end_date)
                                              values (:code, :discount, :description, :start_date, :end_date)');
            $statement->execute([
                'code' => $promotion->getCode(),
                'discount' => $promotion->getDiscount(),
                'description' => $promotion->getDescription(),
                'start_date' => $promotion->getStartDate(),
                'end_date' => $promotion->getEndDate(),
            ]);
    
            // Obtener el ID de la promoción insertada
            $promotionId = $this->pdo->lastInsertId();
    
            // Asociar la promoción con los productos
            if (!empty($productIds)) {
                $sql = $this->pdo->prepare('insert into Product_promotions (id_product, id_promotion)
                                            values (:id_product, :id_promotion)');
                
                foreach ($productIds as $productId) {
                    $sql->execute([
                        'id_product' => $productId,
                        'id_promotion' => $promotionId
                    ]);
                }
            }
    
            $this->pdo->commit();
            return $promotionId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception('No se ha podido insertar una nueva promoción: ' . $e->getMessage());
        }
    }
}