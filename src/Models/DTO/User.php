<?php

namespace App\Models\DTO;

use \DateTime;

/**
 * Classe DTO (attributs + getters/setters ) matérialisant les utilisateurs du site
 */
class User{

    private $id;
    private $email;
    private $password;
    private $registerDate;
    private $firstname;
    private $lastname;


    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }


    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }


    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    public function setRegisterDate(DateTime $registerDate)
    {
        $this->registerDate = $registerDate;
        return $this;
    }


    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }


    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

}