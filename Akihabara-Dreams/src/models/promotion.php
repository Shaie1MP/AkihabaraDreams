<?php
class promotion {
    private $id_promotion;
    private $code;
    private $discount;
    private $description;
    private $start_date;
    private $end_date;

    public function __construct($id_promotion, $code, $discount, $description, $start_date, $end_date) {
        $this->id_promotion = $id_promotion;
        $this->code = $code;
        $this->discount = $discount;
        $this->description = $description;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function getPromotionId() {
        return $this->id_promotion;
    }

    public function getCode() {
        return $this->code;
    }

    public function getDiscount() {
        return $this->discount;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getStartDate() {
        return $this->start_date;
    }

    public function getEndDate() {
        return $this->end_date;
    }
}