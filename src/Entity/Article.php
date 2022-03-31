<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pictureArticle;

    /**
     * @ORM\Column(type="text")
     */
    private $paragraphe;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="article")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Spotlight::class, inversedBy="article")
     */
    private $spotlight;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPictureArticle(): ?string
    {
        return $this->pictureArticle;
    }

    public function setPictureArticle(string $pictureArticle): self
    {
        $this->pictureArticle = $pictureArticle;

        return $this;
    }

    public function getParagraphe(): ?string
    {
        return $this->paragraphe;
    }

    public function setParagraphe(string $paragraphe): self
    {
        $this->paragraphe = $paragraphe;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthor(): ?Profil
    {
        return $this->author;
    }

    public function setAuthor(?Profil $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getSpotlight(): ?Spotlight
    {
        return $this->spotlight;
    }

    public function setSpotlight(?Spotlight $spotlight): self
    {
        $this->spotlight = $spotlight;

        return $this;
    }



    

}
