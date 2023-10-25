<?php

namespace Yosimar\Corona\Model;

class Shelter
{
    private int $id;
    private int $id_review;
    private int $id_store;
    private int $id_product;
    private int $quantity;

    public function __construct()
    {

    }

    public function setId($id): void
    {
        $this->id = $id;
    }
    public function setIdReview($id_review): void
    {
        $this->id_review = $id_review;
    }
    public function setIdStore($id_store): void
    {
        $this->id_store = $id_store;
    }
    public function setIdProduct($id_product): void
    {
        $this->id_product = $id_product;
    }
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getIdReview(): int
    {
        return $this->id_review;
    }
    public function getIdStore(): int
    {
        return $this->id_store;
    }
    public function getIdProduct(): int
    {
        return $this->id_product;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}