<?php

namespace App\Entity;

use App\Repository\ContactTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactTypeRepository::class)
 */
class ContactType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameType;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="contactType")
     */
    private $type;

    public function __construct()
    {
        $this->type = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameType(): ?string
    {
        return $this->nameType;
    }

    public function setNameType(string $nameType): self
    {
        $this->nameType = $nameType;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(Contact $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
            $type->setContactType($this);
        }

        return $this;
    }

    public function removeType(Contact $type): self
    {
        if ($this->type->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getContactType() === $this) {
                $type->setContactType(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNameType();
        return $this->getType();
    }
}
