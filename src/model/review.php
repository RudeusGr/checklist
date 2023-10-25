<?php

namespace Yosimar\Corona\Model;

class Review
{

    private int $id;
    private string $folio;
    private int $id_user;
    private int $id_route;
    private string $date;
    private string $observation;
    private string $signature;

    public function __construct()
    {

    }

    public function setId($id): void
    {
        $this->id = $id;
    }
    public function setFolio($folio): void
    {
        $this->folio = $folio;
    }
    public function setIdUser($id_user): void
    {
        $this->id_user = $id_user;
    }
    public function setIdRoute($id_route): void
    {
        $this->id_route = $id_route;
    }
    public function setDate($date): void
    {
        $this->date = $date;
    }
    public function setObservation($observation): void
    {
        $this->observation = $observation;
    }
    public function setSignature($signature): void
    {
        $this->signature = $signature;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getFolio(): string
    {
        return $this->folio;
    }
    public function getIdUser(): int
    {
        return $this->id_user;
    }
    public function getIdRoute(): int
    {
        return $this->id_route;
    }
    public function getDate(): string
    {
        return $this->date;
    }
    public function getObservation(): string
    {
        return $this->observation;
    }

}