<?php
class Order{
    private $id_order;
    private $id_user;
    private $order_date;
    private $arrival_date;
    private $state;
    private $orderDetails;
    private $address;
    private $billing;


    public function __construct($id_order, $id_user, $order_date = null, $arrival_date = null, $address, $billing, $state) {
        $this->id_order = $id_order;
        $this->id_user = $id_user;
        $this->order_date = $order_date ?: (new DateTime())->format('d-m-Y');
        $this->arrival_date = $arrival_date ?: (new DateTime())->modify('+2 weeks')->format('d-m-Y');
        $this->state = $state;
        $this->orderDetails = [];
        $this->address = $address;
        $this->billing = $billing;
    }

    public function getOrderId(){
        return $this->id_order;
    }

    public function getUserId(){
        return $this->id_user;
    }

    public function getOrderDate(){
        return $this->order_date;
    }

    public function getArrivalDate(){
        return $this->arrival_date;
    }

    public function getState(){
        return $this->state;
    }

    public function getOrderDetails(){
        return $this->orderDetails;
    }
    public function getAddress(){
        return $this->address;
    }
    public function getBilling(){
        return $this->billing;
    }

    public function addOrderDetail(OrderDetails $detail){
        $this->orderDetails[] = $detail;
    }
}
