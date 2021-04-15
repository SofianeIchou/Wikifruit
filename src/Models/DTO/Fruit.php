<?php

namespace App\Models\DTO;


/**
 * Classe DTO (attributs + getters/setters ) matérialisant les fruits du site
 */
class Fruit{

    private $id;
    private $name;
    private $color;
    private $origin;
    private $pricePerKilo;
    private $user;
    private $description;

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor(string $color)
    {
        $this->color = $color;
        return $this;
    }

    public function getOrigin()
    {
        return $this->origin;
    }

    public function setOrigin(string $origin)
    {
        $this->origin = $origin;
        return $this;
    }

    public function getPricePerKilo()
    {
        return $this->pricePerKilo;
    }

    public function setPricePerKilo(float $pricePerKilo)
    {
        $this->pricePerKilo = $pricePerKilo;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

}