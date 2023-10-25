<?php

namespace Yosimar\Corona\Model;

class Store
{
    private int $id;
    private string $code;
    private string $name;

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setCode($code): void
    {
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function geName(): string
    {
        return $this->name;
    }
}