<?php
class OrdersRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getOrders(): array {
        $statement = $this->pdo->prepare('select * from Orders');
        $statement->execute();
        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
        $result = [];

        foreach ($orders as $item) {
            $order = new Order(
                $item['id_order'],
                $item['id_user'],
                $item['order_date'],
                $item['arrive_date'],
                $item['address'],
                $item['billing'],
                $item['state']
            );

            $statement = $this->pdo->prepare('select * from View_Order_Details where id_order = :id_order');
            $statement->execute(['id_order' => $item['id_order']]);
            $details = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($details as $item2) {
                $detail = new OrderDetails(
                    $item2['id_product'],
                    $item2['product_name'],
                    $item2['quantity'],
                    $item2['subtotal']
                );
                $order->addOrderDetail($detail);
            }
            $result[] = $order;
        }
        return $result;
    }

    public function realizeOrder(Order $order, Cart $cart) {
        $this->pdo->beginTransaction();
        try {
            $statement = $this->pdo->prepare('insert into Orders (id_user, address, billing)
                                                    values (:id_user, :address, :billing)');
            $statement->execute([
                'id_user' => $order->getUserId(),
                'address' => $order->getAddress(),
                'billing' => $order->getBilling()
            ]);

            $id_order = $this->pdo->lastInsertId();

            foreach ($cart->getCart() as $item) {
                $statement = $this->pdo->prepare('insert into Order_details (id_order, id_product, quantity, subtotal)
                                                        values (:id_order, :id_product, :quantity, :subtotal)');
                $statement->execute([
                    'id_order' => $id_order,
                    'id_product' => $item['product']->getProductId(),
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['quantity'] * $item['product']->getPrice()
                ]);
            }

            $statement = $this->pdo->prepare('delete from Cart where id_user = :id_user');
            $statement->execute(['id_user' => $order->getUserId()]);

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function myOrders($id): array {
        $statement = $this->pdo->prepare('select * from Orders where id_user = :id_user');
        $statement->execute(['id_user' => $id]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $orders = [];

        foreach ($result as $item) {
            $order = new Order(
                $item['id_order'],
                $item['id_user'],
                $item['order_date'],
                $item['arrive_date'],
                $item['address'],
                $item['billing'],
                $item['state']
            );

            $statement = $this->pdo->prepare('select * from View_Order_Details where id_order = :id_order');
            $statement->execute(['id_order' => $order->getOrderId()]);
            $details = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($details as $item2) {
                $detail = new OrderDetails(
                    $item2['id_product'],
                    $item2['productName'],
                    $item2['quantity'],
                    $item2['subtotal']
                );
                $order->addOrderDetail($detail);
            }
            $orders[] = $order;
        }
        return $orders;
    }
}