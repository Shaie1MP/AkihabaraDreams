<?php
class ProductsRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function searchProduct($id): Product {
        $statement = $this->pdo->prepare('select * from Products where id_product = :id_product');
        $statement->execute(['id_product' => $id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $product = new Product($result['id_product'], 
                               $result['name'], 
                               $result['description'], 
                               $result['price'],
                               $result['stock'],
                               $result['category'],
                               $result['photo']);
        $statement = $this->pdo->prepare('select * from Product_photos where id_product = :id_product');
        $statement->execute(['id_product' => $id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        foreach ($result as $item) {
            $product->addPhotos($item['photo']);
        }

        return $product;
    }

    public function getProducts() {
        $statement = $this->pdo->prepare('select * from Products');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $products = [];

        foreach ($result as $item) {
            $product = new Product($item['id_product'], 
                                    $item['name'], 
                                    $item['description'], 
                                    $item['price'], 
                                    $item['stock'], 
                                    $item['category'],
                                    $item['photo']);
            $statement = $this->pdo->prepare('select * from Product_photos where id_product = :id_product');
            $statement->execute(['id_product' => $item['id_product']]);
            $photos = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($photos as $item2) {
                $product->addPhotos($item2['photo']);
            }

            array_push($products, $product);
        }
        return $products;
    }

    public function insertProducts(Product $product, $newName) {
        $this->pdo->beginTransaction();

        try {
            $statement = $this->pdo->prepare('insert into Products (name, description, price, stock, category, photo)
                                                    values (:name, :description, :price, :stock, :category, :photo)');
            $statement->execute(['name' => $product->getName(), 
                                'description' => $product->getDescription(),
                                'price' => $product->getPrice(),
                                'stock' => $product->getStock(),
                                'category'=> $product->getCategory(),
                                'photo' => $newName]);
            $id = $this->pdo->lastInsertId();

            foreach ($product->getAdditionalPhotos() as $item) {
                $sql = $this->pdo->prepare('insert into Product_photos (id_product, photo)
                                                    values (:id_product, :photo)');
                $sql->execute(['id_product' => $id, 'photo' => $item]);
            }
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function deleteProduct($id) {
        $product = $this->searchProduct($id);

        $statement = $this->pdo->prepare('delete from Products where id_product = :id_product');
        $statement->execute(['id_product' => $id]);

        return $product;
    }

    public function updateProduct(Product $product, $newName) {
        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare('update Products set name = :name,
                                                                        description = :description,
                                                                        price = :price,
                                                                        stock = :stock,
                                                                        category = :category,
                                                                        photo = :photo
                                                    where id_product = :id_product');
            
            $statement->execute(['name' => $product->getName(),
                                    'description' => $product->getDescription(),
                                    'price' => $product->getPrice(),
                                    'stock' => $product->getStock(),
                                    'category'=> $product->getCategory(),
                                    'photo' => $newName,
                                    'id_product' => $product->getId()]);

            if(!empty($product->getAdditionalPhotos())){
                foreach ($product->getAdditionalPhotos() as $item) {
                    $sql = $this->pdo->prepare('insert into Product_photos (id_product, photo) 
                                                        values(:id_product, :photo)');

                    if(!$sql->execute(['id_product' => $product->getId(), 'photo' => $item])){
                        throw new Exception('Error');
                    }
                }
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception($e->getMessage());
        }
    }
}