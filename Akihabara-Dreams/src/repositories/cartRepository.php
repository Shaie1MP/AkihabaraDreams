<?php
class CartRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function searchProduct($id_product) {
        $statement = $this->pdo->prepare('select * from Products where id_product = :id_product');
        $statement->execute(['id_product' => $id_product]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            return $result;
        } else {
            throw new Exception('No se ha encontrado el producto');
        }
    }

    public function saveCartDatabase(Cart $cart) {
        $statement = $this->pdo->prepare('call saveCart(:id_user, :cart_json)');
        $statement->execute(['id_user' => $cart->getId(), 'cart_json' => $cart->getCartJSON()]);
    }

    public function getCartDatabase(Cart $cart) {
        $statement = $this->pdo->prepare('select * from view_cart where id_user = :id_user');
        $statement->execute(['id_user' => $cart->getId()]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCart($id_user) {
        $statement = $this->pdo->prepare('delete from Cart where id_user = :id_user');
        $statement->execute(['id_user' => $id_user]);
    }
}