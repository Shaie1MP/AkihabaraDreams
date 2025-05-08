<?php

class CartRepository {
    protected PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function getProduct($id_product) {
        try {
            $prepare = $this->connection->prepare('select id_product, name, price, photo from Products 
                                                    where id_product = :id_product limit 1');
            $prepare->execute(['id_product' => $id_product]);
            $result = $prepare->fetch(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                return $result;
            } else {
                throw new Exception('No se ha podido encontrar el producto');
            }
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw new Exception('Error de base de datos al buscar el producto');
        }
    }

    public function saveCartDatabase(Cart $cart) {
        $statement = $this->connection->prepare('call SaveCart(:id_user, :cart_json)');
        $statement->execute(['id_user' => $cart->getId(), 'cart_json' => $cart->getCartJSON()]);
    }

    public function getCartDatabase(Cart $cart) {
        $statement = $this->connection->prepare('select * from View_Cart where id_user = :id_user');
        $statement->execute(['id_user' => $cart->getId()]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCart($id_user) {
        $statement = $this->connection->prepare('delete from Cart where id_user = :id_user');
        $statement->execute(['id_user' => $id_user]);
    }
}

