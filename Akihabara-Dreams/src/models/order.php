<?php
class Order {
    private $id_order;
    private $id_user;
    private $order_date;
    private $arrive_date;
    private $order_details;
    private $address;
    private $billing;
    private $state;

    public function __construct($id_order, $id_user, $order_date = null, $arrive_date = null, $address, $billing, $state) {
        $this->id_order = $id_order;
        $this->id_user = $id_user;
        $this->order_date = $order_date ?: (new DateTime())->format('d-m-Y');
        $this->arrive_date = $arrive_date ?: (new DateTime())->modify('+2 weeks')->format('d-m-Y');
        $this->address = $address;
        $this->billing = $billing;
        $this->state = $state;
    }

    public function getOrderId() {
        return $this->id_order;
    }

    public function getUserId() {
        return $this->id_user;
    }

    public function getOrderDate() {
        return $this->order_date;
    }

    public function getArriveDate() {
        return $this->arrive_date;
    }

    public function getOrderDetails() {
        return $this->order_details;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getBilling() {
        return $this->billing;
    }

    public function getState() {
        return $this->state;
    }

    public function addOrderDetail(OrderDetails $detail) {
        $this->order_details[] = $detail;
    }
}