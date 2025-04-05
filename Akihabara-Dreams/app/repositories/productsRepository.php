<?php

class ProductsRepository {

    protected PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }


    public function searchProduct($id): Product {
        $statement = $this->connection->prepare('select * from Products where id_product = :id_product');
        $statement->execute(['id_product' => $id]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $Product = new Product(
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
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $item) {
            $Product->addPhotos($item['photo']);
        }
        return $Product;
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
        $statement->execute(['id' => $id]);
        return $product;
    }

    public function updateProduct(Product $product, $newname) {
        try {
            $this->connection->beginTransaction();

            $statement = $this->connection->prepare('update productos set name = :name, 
                                                                    price = :price, 
                                                                    photo = :photo, 
                                                                    description =: description, 
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
