<?php

namespace Yosimar\Corona\Model;


class Product {
    private int $id;
    private string $name;
    private float $price_bottle;
    private string $type;
    private string $sku;

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPriceBottle(): float {
        return $this->price_bottle;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getSku(): string {
        return $this->sku;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setPriceBottle(float $price_bottle): void {
        $this->price_bottle = $price_bottle;
    }

    public function setType(string $type): void {
        $this->type = $type;
    }

    public function setSku(string $sku): void {
        $this->sku = $sku;
    }
}