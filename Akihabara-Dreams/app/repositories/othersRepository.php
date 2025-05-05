<?php
class OthersRepository {
    protected PDO $connection;

    public function __construct( PDO $connection){
        $this->connection = $connection;
    }

    public function catalog(){
        $statement = $this->connection->prepare('select * from Products');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $products = [];

        foreach ($result as $item) {
            $product = new Product($item['id_product'], 
                                    $item['name'], 
                                    $item['price'], 
                                    $item['photo'], 
                                    $item['description'], 
                                    $item['stock'],
                                    $item['category']);
           
            
            array_push($products, $product);
        }
        return $products;
    }

    public function mangas(){
        $statement = $this->connection->prepare('select * from Products where category = "mangas"');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $products = [];

        foreach ($result as $item) {
            $product = new Product($item['id_product'], 
                                    $item['name'], 
                                    $item['price'], 
                                    $item['photo'], 
                                    $item['description'], 
                                    $item['stock'],
                                    $item['category']);
           
            
            array_push($products, $product);
        }
        return $products;
    }

    public function figures(){
        $statement = $this->connection->prepare('select * from Products where category = "figuras"');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $products = [];

        foreach ($result as $item) {
            $product = new Product($item['id_product'], 
                                    $item['name'], 
                                    $item['price'], 
                                    $item['photo'], 
                                    $item['description'], 
                                    $item['stock'],
                                    $item['category']);
           
            
            array_push($products, $product);
        }
        return $products;
    }

    public function merchandising(){
        $statement = $this->connection->prepare('select * from Products where category = "merchandising"');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $products = [];

        foreach ($result as $item) {
            $product = new Product($item['id_product'], 
                                    $item['name'], 
                                    $item['price'], 
                                    $item['photo'], 
                                    $item['description'], 
                                    $item['stock'],
                                    $item['category']);
           
            
            array_push($products, $product);
        }
        return $products;
    }

    public function promotions(){
        // Obtener productos que están en promociones activas
        $statement = $this->connection->prepare('
            SELECT p.*, pr.discount, pr.description as promotion_description
            FROM Products p
            JOIN Product_Promotions pp ON p.id_product = pp.id_product
            JOIN Promotion pr ON pp.id_promotion = pr.id_promotion
            WHERE pr.start_date <= CURRENT_DATE AND pr.end_date >= CURRENT_DATE
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
            
            // Añadir información de promoción al producto
            $product->setDiscount($item['discount']);
            $product->setPromotionDescription($item['promotion_description']);
            $product->setDiscountedPrice($item['price'] * (1 - $item['discount'] / 100));
            
            array_push($products, $product);
        }
        return $products;
    }

    public function index(){
        $statement = $this->connection->prepare('select * from Best_Selling_Products');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $products = [];

        foreach ($result as $item) {
            $product = new Product($item['id_product'], 
                                    $item['name'], 
                                    null, 
                                    $item['photo'], 
                                    $item['description'], 
                                    null,
                                    null);
            array_push($products, $product);
        }
        return $products;
    }
}
?>