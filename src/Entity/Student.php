<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Column(type="string", length=25)
     */
    private $FirstName;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $LastName;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumEtud;


    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getNumEtud(): ?int
    {
        return $this->NumEtud;
    }

    public function setNumEtud(int $NumEtud): self
    {
        $this->NumEtud = $NumEtud;

        return $this;
    }
}
