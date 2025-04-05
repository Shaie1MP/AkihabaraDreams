<?php

class OrdersRepository {
    private PDO $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function showOrders(): array {
        $statement = $this->connection->prepare('select * from Orders');
        $statement->execute();
        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
        $result = [];

        foreach ($orders as $item){
            $order = new Order(
                $item['id_order'],
                $item['id_user'],
                $item['order_date'],
                $item['arrival_date'],
                $item['address'],
                $item['billing'],
                $item['state']
            );

            $statement = $this->connection->prepare('select * from View_Order_Details where id_order = :id_order');
            $statement->execute(['id_order' => $item['id_order']]);
            $details = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($details as $item2) {
                $detail = new OrderDetails($item2['id_product'], 
                                            $item2['quantity'], 
                                            $item2['subtotal'], 
                                            $item2['productName']);
                $order->addOrderDetail($detail);
            }
            $result[] = $order;
        }
        return $result;
    }
    
    public function realizeOrder(Order $order, Cart $cart) {
        $this->connection->beginTransaction();
        try {
            $statement = $this->connection->prepare('insert into Orders (id_user, address, billing)
                                                        values (:id_user, :address, :billing)');
            $statement->execute([
                'id_user' => $order->getUserId(),
                'address' => $order->getAddress(),
                'billing' => $order->getBilling()
            ]);

            $id_order = $this->connection->lastInsertId();

            foreach ($cart->getCart() as $item) {
                $statement = $this->connection->prepare('insert into Order_details (id_order, id_product, quantity, subtotal)
                                                            values (:id_order, :id_product, :quantity, :subtotal)');
                $statement->execute([
                    'id_order' => $id_order,
                    'id_product' => $item['id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['quantity'] * $item['product']->getPrice()
                ]);

            }

            $statement = $this->connection->prepare('delete from Cart where id_user = :id_user');
            $statement->execute(['id_user'=> $order->getUserId()]);
            $this->connection->commit();

        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function myOrders($id): array {
        $statement = $this->connection->prepare('select * from Orders where id_user = :id_user');
        $statement->execute(['id_user' => $id]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $orders = [];

        foreach ($result as $item) {
            $order = new Order(
                $item['id_order'],
                $item['id_user'],
                $item['order_date'],
                $item['arrival_date'],
                $item['address'],
                $item['billing'],
                $item['state']
                
                
            );
            $statement = $this->connection->prepare('select * from View_Order_Details where id_order = :id_order');
            $statement->execute(['id_order' => $order->getOrderId()]);
            $details = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($details as $item2) {
                $detail = new OrderDetails($item2['id_product'], 
                                            $item2['quantity'], 
                                            $item2['subtotal'], 
                                            $item2['product_name']);
                $order->addOrderDetail($detail);
            }
            $orders[] = $order;
        }
        return $orders;
    }
}

