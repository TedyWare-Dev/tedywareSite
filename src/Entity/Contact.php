<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length( * min = 2, * max = 100, * minMessage = "Votre nom doit contenir au moins {{ limit }} characteres", * maxMessage = "Votre nom ne doit pas contenir plus de {{ limit }} characteres" * )
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length( * min = 20, * max = 5000, * minMessage = "Votre message doit contenir au moins {{ limit }} characteres", * maxMessage = "Votre message ne doit pas contenir plus de {{ limit }} characteres" * )
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length( * min = 10, * max = 10)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email( * message = "L'/email '{{ value }}' n'est pas valide." * )
     * @Assert\NotBlank
     */
    private $mail;

    /**
     * @ORM\ManyToOne(targetEntity=ContactType::class, inversedBy="type")
     */
    private $contactType;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getContactType(): ?ContactType
    {
        return $this->contactType;
    }

    public function setContactType(?ContactType $contactType): self
    {
        $this->contactType = $contactType;

        return $this;
    }


    public function __toString(): string
    {
        return $this->getName();
        return $this->getMessage();
        return $this->getPhone();
        return $this->getMail();
        return $this->getContactType();
    }
}
