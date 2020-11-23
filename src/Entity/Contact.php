<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Constraints;

class Contact
{
    
    /**
     *
     * @var string|null
     */
    private $lastname;

    /**
     *
     * @var string|null
     */
    private $firstname;

    /**
     * @Constraint\Email
     * @Constraint\NotBlank
     *
     * @var string
     */
    private $email;
    
    /**
     * @Constraint\Lenght(min=3, max=2048)
     * @Constraint\NotBlank
     *
     * @var ?string
     */
    private $message;
    
    /**
     * 
     * @Constraint\NotNull
     * 
     * @var Immo
     */
    private $immo;

    public function getLastname(): ?string {
        return $this->lastname;
    }

    public function getFirstname(): ?string {
        return $this->firstname;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function getMessage(): ?string {
        return $this->message;
    }

    public function getImmo(): Immo {
        return $this->immo;
    }

    public function setLastname(?string $lastname): Contact {
        $this->lastname = $lastname;
        return $this;
    }

    public function setFirstname(?string $firstname): Contact {
        $this->firstname = $firstname;
        return $this;
    }

    public function setEmail(?string $email): Contact {
        $this->email = $email;
        return $this;
    }

    public function setMessage(?string $message): Contact {
        $this->message = $essage;
        return $this;
    }

    public function setImmo(Immo $immo): Contact {
        $this->immo = $immo;
        return $this;
    }
}