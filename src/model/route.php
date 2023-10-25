<?php

namespace Yosimar\Corona\Model;

class Route
{
    private int $id;
    private string $name;
    private string $operador;

    public function __construct()
    {

    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setOperador(string $operador): void
    {
        $this->operador = $operador;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOperador(): string
    {
        return $this->operador;
    }

}