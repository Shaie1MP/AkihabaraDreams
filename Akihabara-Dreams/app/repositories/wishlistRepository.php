<?php

class WishlistRepository {
    private PDO $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function getConnection() {
        return $this->connection;
    }

    /**
     * Obtiene la wishlist de un usuario
     * 
     * @param int $userId ID del usuario
     * @return array Array con los productos en la wishlist
     */
    public function getWishlist($userId) {
        try {
            $statement = $this->connection->prepare('
                select * from View_Wishlist 
                where id_user = :id_user 
                order by date_added desc
            ');
            $statement->execute(['id_user' => $userId]);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener wishlist: ' . $e->getMessage());
            throw new Exception('Error al obtener la lista de deseos');
        }
    }

    /**
     * Añade un producto a la wishlist
     * 
     * @param int $userId ID del usuario
     * @param int $productId ID del producto
     * @return bool True si se añadió correctamente, False en caso contrario
     */
    public function addToWishlist($userId, $productId) {
        try {
            // Verificar si el producto ya está en la wishlist
            $statement = $this->connection->prepare('
                select count(*) from Wishlist 
                where id_user = :id_user and id_product = :id_product
            ');
            $statement->execute([
                'id_user' => $userId,
                'id_product' => $productId
            ]);
            
            if ($statement->fetchColumn() > 0) {
                return true; 
            }

            // Añadir el producto a la wishlist
            $statement = $this->connection->prepare('
                insert into Wishlist (id_user, id_product) 
                values (:id_user, :id_product)
            ');
            $result = $statement->execute([
                'id_user' => $userId,
                'id_product' => $productId
            ]);

            return $result;
        } catch (PDOException $e) {
            error_log('Error al añadir a wishlist: ' . $e->getMessage());
            throw new Exception('Error al añadir el producto a la lista de deseos');
        }
    }

    /**
     * Elimina un producto de la wishlist
     * 
     * @param int $userId ID del usuario
     * @param int $productId ID del producto
     * @return bool True si se eliminó correctamente, False en caso contrario
     */
    public function removeFromWishlist($userId, $productId) {
        try {
            $statement = $this->connection->prepare('
                delete from Wishlist 
                where id_user = :id_user and id_product = :id_product
            ');
            $result = $statement->execute([
                'id_user' => $userId,
                'id_product' => $productId
            ]);

            return $result;
        } catch (PDOException $e) {
            error_log('Error al eliminar de wishlist: ' . $e->getMessage());
            throw new Exception('Error al eliminar el producto de la lista de deseos');
        }
    }

    /**
     * Verifica si un producto está en la wishlist de un usuario
     * 
     * @param int $userId ID del usuario
     * @param int $productId ID del producto
     * @return bool True si el producto está en la wishlist, False en caso contrario
     */
    public function isInWishlist($userId, $productId) {
        try {
            $statement = $this->connection->prepare('
                select count(*) from Wishlist 
                where id_user = :id_user and id_product = :id_product
            ');
            $statement->execute([
                'id_user' => $userId,
                'id_product' => $productId
            ]);
            
            return $statement->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Error al verificar wishlist: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene el número de productos en la wishlist de un usuario
     * 
     * @param int $userId ID del usuario
     * @return int Número de productos en la wishlist
     */
    public function getWishlistCount($userId) {
        try {
            $statement = $this->connection->prepare('
                select count(*) from Wishlist 
                where id_user = :id_user
            ');
            $statement->execute(['id_user' => $userId]);
            
            return (int)$statement->fetchColumn();
        } catch (PDOException $e) {
            error_log('Error al contar wishlist: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Vacía la wishlist de un usuario
     * 
     * @param int $userId ID del usuario
     * @return bool True si se vació correctamente, False en caso contrario
     */
    public function clearWishlist($userId) {
        try {
            $statement = $this->connection->prepare('
                delete from Wishlist 
                where id_user = :id_user
            ');
            $result = $statement->execute(['id_user' => $userId]);

            return $result;
        } catch (PDOException $e) {
            error_log('Error al vaciar wishlist: ' . $e->getMessage());
            throw new Exception('Error al vaciar la lista de deseos');
        }
    }
}
