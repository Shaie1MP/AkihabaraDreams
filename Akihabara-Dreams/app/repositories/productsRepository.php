<?php

class ProductsRepository {

    protected PDO $connection;
    protected ?PromotionsRepository $promotionsRepository = null;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }


    private function getPromotionsRepository() {
        if ($this->promotionsRepository === null) {
            $this->promotionsRepository = new PromotionsRepository($this->connection);
        }
        return $this->promotionsRepository;
    }

    // Método para cargar promociones en un producto
    private function loadProductPromotions(Product $product) {
        // Obtener promociones activas para el producto
        $promotions = $this->getPromotionsRepository()->getPromotionsForProduct($product->getId());
        
        if (!empty($promotions)) {
            // Usar la promoción con mayor descuento (la primera, ya que están ordenadas por descuento DESC)
            $bestPromotion = $promotions[0];
            
            // Establecer los datos de promoción en el producto
            $product->setDiscount($bestPromotion->getDiscount());
            $product->setPromotionDescription($bestPromotion->getDescription());
            $product->setDiscountedPrice($bestPromotion->calculateDiscountedPrice($product->getPrice()));
            
            // También establecer la propiedad promotion para compatibilidad
            $product->promotion = [
                'id' => $bestPromotion->getId(),
                'code' => $bestPromotion->getCode(),
                'discount' => $bestPromotion->getDiscount(),
                'description' => $bestPromotion->getDescription(),
                'start_date' => $bestPromotion->getStartDate(),
                'end_date' => $bestPromotion->getEndDate(),
                'discounted_price' => $bestPromotion->calculateDiscountedPrice($product->getPrice())
            ];
        }
        
        return $product;
    }

    public function getProductsOrdered($sortCriteria = 'recent') {
        try {
            $query = 'SELECT * FROM Products';
            
            // Aplicar ordenamiento según el criterio
            switch ($sortCriteria) {
                case 'old':
                    $query .= ' ORDER BY id_product ASC';
                    break;
                    
                case 'recent':
                    $query .= ' ORDER BY id_product DESC';
                    break;
                    
                case 'price-low':
                    $query .= ' ORDER BY price ASC';
                    break;
                    
                case 'price-high':
                    $query .= ' ORDER BY price DESC';
                    break;
                    
                case 'discount':
                    // Para ordenar por descuento, necesitamos una consulta más compleja
                    $query = 'SELECT p.*, IFNULL(pr.discount, 0) as discount 
                              FROM Products p 
                              LEFT JOIN Product_promotions pp ON p.id_product = pp.id_product 
                              LEFT JOIN Promotion pr ON pp.id_promotion = pr.id_promotion 
                                                    AND pr.start_date <= CURRENT_DATE 
                                                    AND pr.end_date >= CURRENT_DATE
                              ORDER BY discount DESC, p.id_product DESC';
                    break;
                    
                default:
                    $query .= ' ORDER BY id_product DESC';
                    break;
            }
            
            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            $products = [];
            foreach ($result as $item) {
                $product = new Product(
                    $item['id_product'],
                    $item['name'],
                    $item['description'],
                    $item['price'],
                    $item['stock'],
                    $item['photo'],
                    $item['category']
                );
                
                // Cargar promociones para este producto
                $this->loadProductPromotions($product);
                
                $products[] = $product;
            }
            
            return $products;
        } catch (Exception $e) {
            error_log('Error al obtener productos ordenados: ' . $e->getMessage());
            return [];
        }
    }

    public function searchProduct($id): Product {
        $statement = $this->connection->prepare('select * from Products where id_product = :id_product');
        $statement->execute(['id_product' => $id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $product = new Product(
            $result['id_product'],
            $result['name'],
            $result['price'],
            $result['photo'],
            $result['description'],
            $result['stock'],
            $result['category']
        );

        $statement = $this->connection->prepare('select * from Product_photos where id_product = :id_product');
        $statement->execute(['id_product' => $id]);
        $photos = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($photos as $item) {
            $product->addPhotos($item['photo']);
        }
        
        // Cargar promociones para el producto
        return $this->loadProductPromotions($product);
    }

    public function showProducts() {
        $statement = $this->connection->prepare('select * from Products');
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

            $statement = $this->connection->prepare('select * from Product_photos where id_product = :id_product');
            $statement->execute(['id_product' => $item['id_product']]);
            $photos = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($photos as $item2) {
                $product->addPhotos($item2['photo']);
            }
            
            // Cargar promociones para el producto
            $product = $this->loadProductPromotions($product);
            
            array_push($products, $product);
        }

        return $products;
    }

    public function insertProduct(Product $product, $newName) {
        $this->connection->beginTransaction();

        try {
            $statement = $this->connection->prepare('insert into Products (name, price, photo, description, stock, category) 
                                                        values (:name, :price, :photo, :description, :stock, :category)');
            $statement->execute([
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'photo' => $newName,
                'description' => $product->getDescription(),
                'stock' => $product->getStock(),
                'category' => $product->getCategory()
            ]);

            $id = $this->connection->lastInsertId();

            foreach ($product->getAdditionalPhotos() as $item) {
                $sql = $this->connection->prepare('insert into Product_photos (id_product, photo) 
                                                    values(:id_product, :photo)');
                $sql->execute(['id_product' => $id, 'photo' => $item]);
            }
            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function deleteProduct($id) {
        $product = $this->searchProduct($id);

        $statement = $this->connection->prepare('delete from Products where id_product = :id_product');
        $statement->execute(['id_product' => $id]);

        return $product;
    }

    public function updateProduct(Product $product, $newname) {
        try {
            $this->connection->beginTransaction();

            $statement = $this->connection->prepare('update Products set name = :name, 
                                                                    price = :price, 
                                                                    photo = :photo, 
                                                                    description = :description, 
                                                                    stock = :stock,
                                                                    category = :category 
                                                where id_product = :id_product');
            $statement->execute([
                'id_product' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'photo' => $newname,
                'description' => $product->getDescription(),
                'stock' => $product->getStock(),
                'category' => $product->getCategory()
            ]);

            if (!empty($product->getAdditionalPhotos())) {
                foreach ($product->getAdditionalPhotos() as $item) {
                    $sql = $this->connection->prepare('insert into Product_photos (id_product, photo) 
                                                    values (:id_product, :photo)');
                    if (!$sql->execute(['id_product' => $product->getId(), 'photo' => $item])) {
                        throw new Exception('Error');
                    }
                }
            }

            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
