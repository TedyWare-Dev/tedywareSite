<?php

namespace App\Entity;

use App\Repository\SpotlightRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpotlightRepository::class)
 */
class Spotlight
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $onSpotlight;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="spotlight")
     */
    private $article;

    public function __construct()
    {
        $this->article = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOnSpotlight(): ?bool
    {
        return $this->onSpotlight;
    }

    public function setOnSpotlight(?bool $onSpotlight): self
    {
        $this->onSpotlight = $onSpotlight;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
            $article->setSpotlight($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getSpotlight() === $this) {
                $article->setSpotlight(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getOnSpotlight();
    }

}
