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
                $item['billing'],  // Billing parameter
                $item['address'],  // Address parameter
                $item['state']     // State parameter
            );

            $statement = $this->connection->prepare('select * from View_Order_Details where id_order = :id_order');
            $statement->execute(['id_order' => $item['id_order']]);
            $details = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($details as $item2) {
                $detail = new OrderDetails($item2['id_product'], 
                                            $item2['quantity'], 
                                            $item2['subtotal'], 
                                            $item2['product_name']);
                $order->addOrderDetail($detail);
            }
            $result[] = $order;
        }
        return $result;
    }
    
    public function realizeOrder(Order $order, Cart $cart) {
        $this->connection->beginTransaction();
        try {
            $statement = $this->connection->prepare('insert into Orders (id_user, address, billing, state)
                                                    values (:id_user, :address, :billing, :state)');
            $statement->execute([
                'id_user' => $order->getUserId(),
                'billing' => $order->getBilling(),
                'address' => $order->getAddress(),
                'state' => $order->getState()
            ]);

            $id_order = $this->connection->lastInsertId();

            foreach ($cart->getCart() as $item) {
                $subtotal = $item['quantity'] * $item['product']->getPrice();
                $statement = $this->connection->prepare('insert into Order_details (id_order, id_product, quantity, subtotal)
                                                        values (:id_order, :id_product, :quantity, :subtotal)');
                $statement->execute([
                    'id_order' => $id_order,
                    'id_product' => $item['id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal
                ]);
                
                // Registrar en el log para depuración
                error_log("Añadido producto al pedido: ID={$item['id']}, Cantidad={$item['quantity']}, Subtotal={$subtotal}");
            }

            $statement = $this->connection->prepare('delete from Cart where id_user = :id_user');
            $statement->execute(['id_user'=> $order->getUserId()]);
            $this->connection->commit();
            
            return $id_order;

        } catch (Exception $e) {
            $this->connection->rollBack();
            error_log("Error al crear pedido: " . $e->getMessage());
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
                $item['billing'],  // Billing parameter
                $item['address'],  // Address parameter
                $item['state']     // State parameter
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
    
    /**
     * Obtiene un pedido por su ID
     * 
     * @param int $orderId ID del pedido
     * @return Order|null Pedido encontrado o null si no existe
     */
    public function getOrderById($orderId) {
        try {
            $statement = $this->connection->prepare('select * from Orders where id_order = :id_order');
            $statement->execute(['id_order' => $orderId]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                $order = new Order(
                    $result['id_order'],
                    $result['id_user'],
                    $result['order_date'],
                    $result['arrival_date'],
                    $result['billing'],  // Billing parameter
                    $result['address'],  // Address parameter
                    $result['state']     // State parameter
                );
                
                // Modificar esta consulta para obtener los detalles del pedido correctamente
                $statement = $this->connection->prepare('
                    SELECT od.*, p.name as product_name 
                    FROM Order_details od 
                    JOIN Products p ON od.id_product = p.id_product 
                    WHERE od.id_order = :id_order
                ');
                $statement->execute(['id_order' => $orderId]);
                $details = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($details as $item) {
                    $detail = new OrderDetails(
                        $item['id_product'],
                        $item['quantity'],
                        $item['subtotal'],
                        $item['product_name']
                    );
                    
                    $order->addOrderDetail($detail);
                }
                
                return $order;
            }
            
            return null;
        } catch (PDOException $e) {
            error_log("Error al obtener pedido: " . $e->getMessage());
            return null;
        }
    }
}
