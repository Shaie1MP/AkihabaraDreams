<?php
class Wishlist {
    private $id;
    private $userId;
    private $items = [];

    public function __construct($userId, $items = []) {
        $this->userId = $userId;
        $this->items = $items;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getItems() {
        return $this->items;
    }

    public function addItem($productId) {
        // Verificar si el producto ya está en la wishlist
        foreach ($this->items as $item) {
            if ($item['id_product'] == $productId) {
                return; 
            }
        }

        // Añadir el producto a la wishlist
        $this->items[] = [
            'id_product' => $productId,
            'date_added' => date('Y-m-d H:i:s')
        ];
    }

    public function removeItem($productId) {
        foreach ($this->items as $key => $item) {
            if ($item['id_product'] == $productId) {
                unset($this->items[$key]);
                $this->items = array_values($this->items); // Reindexar el array
                return;
            }
        }
    }

    public function hasProduct(int $productId): bool {
        foreach ($this->items as $item) {
            if ($item['id_product'] == $productId) {
                return true;
            }
        }
        return false;
    }

    public function isEmpty(): bool {
        return empty($this->items);
    }

    public function count(): int {
        return count($this->items);
    }
}
