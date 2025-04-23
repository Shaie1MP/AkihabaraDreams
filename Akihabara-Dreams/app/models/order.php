<?php
class Order{
    private $id_order;
    private $id_user;
    private $order_date;
    private $arrival_date;
    private $address;
    private $billing;
    private $state;
    private $orderDetails;
    
    public function __construct($id_order, $id_user, $order_date = null, $arrival_date = null, $billing, $address, $state) {
        $this->id_order = $id_order;
        $this->id_user = $id_user;
        $this->order_date = $order_date ?: (new DateTime())->format('d-m-Y');
        $this->arrival_date = $arrival_date ?: (new DateTime())->modify('+2 weeks')->format('d-m-Y');
        $this->billing = $billing;
        $this->address = $address;
        $this->state = $state;
        $this->orderDetails = [];
    }

    public function getOrderId(){
        return $this->id_order;
    }
    
    public function setOrderId($id_order){
        $this->id_order = $id_order;
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

    public function getAddress(){
        return $this->address;
    }
    
    public function getBilling(){
        return $this->billing;
    }

    public function getState(){
        return $this->state;
    }

    public function getOrderDetails(){
        return $this->orderDetails;
    }
    
    public function addOrderDetail(OrderDetails $detail){
        $this->orderDetails[] = $detail;
    }
}
